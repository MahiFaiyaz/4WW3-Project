<?php
    // Include validate form
    include 'validate_form.php';
 
    $errors = array();

    // check all fields passed in through POST are valid
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
        
            // if all fields are valid, include config.php which has database info (username, pass, etc)
            require 'config.php';
            $dsn = "mysql:host=$servername;dbname=$dbname;charset=UTF8";
        
            try {
                // Search Users table for the email given, if the email already exists, show an alert and refresh the page
                $pdo = new PDO($dsn, $username, $password);
                $stmt = $pdo->prepare("SELECT Email FROM Users Where Email = ?");
                $stmt->bindParam(1, $userEmail);
                $stmt->execute();
                if ($stmt->rowCount() > 0 ) {
                    echo "<script>alert('Email Already Exists');document.location='../registration.php'</script>";
                
                // Otherwise, insert all data into the Users table
                } else {
                    $stmt = $pdo->prepare("INSERT INTO Users (Name, Gender, Email, Password, DateOfBirth)
                    Values (?, ?, ?, ?, ?)");
                    $stmt->bindParam(1, $name);
                    $stmt->bindParam(2, $gender);
                    $stmt->bindParam(3, $userEmail);
                    $stmt->bindParam(4, $userPassword);
                    $stmt->bindParam(5, $userBday);
                    if ($stmt->execute()){
                        // if statement is executed successfully, start a session with the new email (effectively logging the user in)
                        // and redirect to the home page.
                        session_start();
                        $_SESSION['Email'] = $userEmail;
                        header('Location: '. '../index.php');
                    }
                }                 
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
            $pdo = null;
        } else  {echo "Error found.";}
    }
?>