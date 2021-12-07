<?php
    session_start();
    include 'validate_form.php';
 
    $errors = array();

    if (isset($_SESSION['Email']) && !empty($_SESSION['Email'])) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            validateField($errors, 'libraryName');
            validateField($errors, 'Latitude');
            validateField($errors, 'Longitude');

            if (count($errors) == 0) {
                $name = $_POST['libraryName'];
                $latitude = $_POST['Latitude'];
                $longitude = $_POST['Longitude'];
                $libDesc = $_POST['libraryDesc'];
            
                require 'config.php';
                $dsn = "mysql:host=$servername;dbname=$dbname;charset=UTF8";
            
                try {
                    $pdo = new PDO($dsn, $username, $password);
                    $stmt = $pdo->prepare("SELECT `Name` from Library Where `Name` = ?");
                    $stmt->bindParam(1, $name);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                        echo "<script>alert('Library Name Already Exists');document.location='../submission.php'</script>";
                    } else {
                        $stmt = $pdo->prepare("SELECT * FROM Users Where Email = ?");
                        $stmt->bindParam(1, $_SESSION['Email']);
                        $stmt->execute();
                        $results = $stmt->fetch();
                        $userId = $results['Id'];

                        if (isset($_FILES['libraryImg']['name']) && !empty($_FILES['libraryImg']['name'])) {
                            $file_name = 'images/' . $_FILES['libraryImg']['name'];
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
    
                        $stmt = $pdo->prepare("INSERT INTO `Library` (`Name`, `Latitude`, `Longitude`, `Description`, `ImageFilePath`, `UserId`) VALUES (?, ?, ?, ?, ?, ?)");
                        $stmt->bindParam(1, $name);
                        $stmt->bindParam(2, $latitude);
                        $stmt->bindParam(3, $longitude);
                        $stmt->bindParam(4, $libDesc);
                        $stmt->bindParam(5, $file_name);
                        $stmt->bindParam(6, $userId);
                        $stmt->execute();                                     
                        echo "<script>alert('Library Added Successful');document.location='../individual_result.php?Library=$name'</script>";    
                    }

                } catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
                $pdo = null;
            } else  {echo "Error found.";}
        } else {echo "Invalid Method";}
    } else {echo "You must be logged in";}
?>

