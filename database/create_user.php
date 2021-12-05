<?php
    session_start();
    include 'validate_form.php';
 
    $errors = array();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        validateField($errors, 'create_token');
        validateField($errors, 'firstName');
        validateField($errors, 'lastName');
        validateField($errors, 'gender');
        validateField($errors, 'userEmail');
        validateField($errors, 'userPassword');
        validateField($errors, 'userBday');

        if (count($errors) == 0) {
            $name = $_POST['firstName'] . ' ' . $_POST['lastName'];
            $gender = $_POST['gender'];
            $userEmail = $_POST['userEmail'];
            $userPassword = password_hash($_POST['userPassword'], PASSWORD_DEFAULT);
            $userBday = $_POST['userBday'];
        
            require 'config.php';
            $dsn = "mysql:host=$servername;dbname=$dbname;charset=UTF8";
        
            try {
                $pdo = new PDO($dsn, $username, $password);
                $stmt = $pdo->prepare("SELECT Email FROM Users Where Email = ?");
                $stmt->bindParam(1, $userEmail);
                $stmt->execute();
                if ($stmt->rowCount() > 0 ) {
                    echo "<script>alert('Email Already Exists');document.location='../registration.php'</script>";
                } else {
                    $stmt = $pdo->prepare("INSERT INTO Users (Name, Gender, Email, Password, DateOfBirth)
                    Values (?, ?, ?, ?, ?)");
                    $stmt->bindParam(1, $name);
                    $stmt->bindParam(2, $gender);
                    $stmt->bindParam(3, $userEmail);
                    $stmt->bindParam(4, $userPassword);
                    $stmt->bindParam(5, $userBday);
                    if ($stmt->execute());
                        session_destroy();
                        echo "<script>alert('Registration Successful');document.location='../search.php'</script>";
                }                 
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
            $pdo = null;
        } else  {echo "Error found.";}
    }
?>