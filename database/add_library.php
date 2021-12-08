<?php
// Start session, include validate form
    session_start();
    include 'validate_form.php';

    // generates a random string to be added to the image file path (incase an image with the same name of 
    // an existing one is submitted, this will prevent overwrite)
    function generateRandomString($length=20) {
        $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randString = '';
        $charStringLen = strlen($char) - 1;
        for ($i = 0; $i < $length; $i++) {
            $randString .= $char[rand(0, $charStringLen)];
        }
        return $randString;
    }
 
    $errors = array();

    // Check if sessions email is set, and if the correct request method is given
    if (isset($_SESSION['Email']) && !empty($_SESSION['Email'])) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // check that all fields are valid
            validateField($errors, 'libraryName');
            // Checks that a value for latitude and longitude are set
            // !empty isn't checked because 0 is a valid latitude and longitude
            if (!(isset($_POST['Latitude']))) {
                $errors[$filed_name] = 'Required';
            }
            if (!(isset($_POST['Longitude']))) {
                $errors[$filed_name] = 'Required';
            }
            if (count($errors) == 0) {
                $name = $_POST['libraryName'];
                $latitude = $_POST['Latitude'];
                $longitude = $_POST['Longitude'];
                $libDesc = $_POST['libraryDesc'];
                // config.php includes server information (dbname, password, username, servername)
                require 'config.php';
                $dsn = "mysql:host=$servername;dbname=$dbname;charset=UTF8";
                
                // try new PDO, prepare statement to get Name from library where Name is the library name from the POST method
                try {
                    $pdo = new PDO($dsn, $username, $password);
                    $stmt = $pdo->prepare("SELECT `Name` from Library Where `Name` = ?");
                    $stmt->bindParam(1, $name);
                    $stmt->execute();
                    // If that library name has already been used, use a pop up alert and go back to submission screen
                    if ($stmt->rowCount() > 0) {
                        echo "<script>alert('Library Name Already Exists');document.location='../submission.php'</script>";
                    } else {
                        // otherwise retrieve user ID using session email
                        $stmt = $pdo->prepare("SELECT * FROM Users Where Email = ?");
                        $stmt->bindParam(1, $_SESSION['Email']);
                        $stmt->execute();
                        $results = $stmt->fetch();
                        $userId = $results['Id'];
                        // if a file is given for the image input, upload the file to the s3 bucket using putObject
                        if (isset($_FILES['libraryImg']['name']) && !empty($_FILES['libraryImg']['name'])) {
                            $file_name = 'images/' . generateRandomString() . $_FILES['libraryImg']['name'];
                            $temp_file_location = $_FILES['libraryImg']['tmp_name'];
                            require 's3.php';
                
                            try {
                                $s3Client->putObject([
                                    'Bucket' => $bucketName,
                                    'Key' => $file_name,
                                    'SourceFile' => $temp_file_location,
                                ]);
                            } catch (Aws\S3\Exception\S3Exception $e) {
                                echo "There was an error uploading the file.\n" . $e;
                            }
                        }
                        // Insert POST information into the Library table using PDO prepare statements
                        $stmt = $pdo->prepare("INSERT INTO `Library` (`Name`, `Latitude`, `Longitude`, `Description`, `ImageFilePath`, `UserId`) VALUES (?, ?, ?, ?, ?, ?)");
                        $stmt->bindParam(1, $name);
                        $stmt->bindParam(2, $latitude);
                        $stmt->bindParam(3, $longitude);
                        $stmt->bindParam(4, $libDesc);
                        $stmt->bindParam(5, $file_name);
                        $stmt->bindParam(6, $userId);
                        $stmt->execute();                                     
                        // redirect page to the newly created library
                        header ("Location: ../individual_result.php?Library=" . $name);
                        exit();
                    }

                } catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
                // set pdo to null;
                $pdo = null;
            } else  {echo "Error found.";}
        } else {echo "Invalid Method";}
    } else {echo "You must be logged in";}
?>

