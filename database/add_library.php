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
                $imgPath = $_POST['libraryImg'];
                $vidPath = $_POST['libraryVid'];
            
                require 'config.php';
                $dsn = "mysql:host=$servername;dbname=$dbname;charset=UTF8";
            
                try {
                    $pdo = new PDO($dsn, $username, $password);
                    $stmt = $pdo->prepare("SELECT * FROM Users Where Email = ?");
                    $stmt->bindParam(1, $_SESSION['Email']);
                    $stmt->execute();
                    $results = $stmt->fetch();
                    $userId = $results['Id'];

                    $stmt = $pdo->prepare("INSERT INTO `Library` (`Name`, `Latitude`, `Longitude`, `Description`, `ImageFilePath`, `VideoFilePath`, `UserId`) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bindParam(1, $name);
                    $stmt->bindParam(2, $latitude);
                    $stmt->bindParam(3, $longitude);
                    $stmt->bindParam(4, $libDesc);
                    $stmt->bindParam(5, $imgPath);
                    $stmt->bindParam(6, $vidPath);
                    $stmt->bindParam(7, $userId);
                    $stmt->execute();                                     

                    echo "<script>alert('Library Added Successful');document.location='../individual_result.php?Library=$name'</script>";
                } catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
                $pdo = null;
            } else  {echo "Error found.";}
        } else {echo "Invalid Method";}
    } else {echo "You must be logged in";}
?>

