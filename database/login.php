<?php
    session_start();
    include 'validate_form.php';
    $errors = array();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        validateField($errors, 'loginEmail');
        validateField($errors, 'loginPassword');
        if (count($errors) == 0) {
            $loginEmail = $_POST['loginEmail'];
            $loginPassword = $_POST['loginPassword'];
        }

        require 'config.php';
        $dsn = "mysql:host=$servername;dbname=$dbname;charset=UTF8";
        try {
            $pdo = new PDO($dsn, $username, $password);
            $stmt = $pdo->prepare("SELECT * FROM Users Where Email = ?");
            $stmt->bindParam(1, $loginEmail);
            $stmt->execute();
            $results = $stmt->fetch();

            if(password_verify($loginPassword, $results['Password'])) {
                $_SESSION['Email'] = $results['Email'];
                if((isset($_POST['rememberMe'])) && !empty($_POST['rememberMe'])) {
                    setcookie('Email', $loginEmail, time() + (86400 * 30), "/");
                } else {
                    setcookie('Email', null, -1, "/");
                }
                echo "<script>alert('Login Successful');document.location='../search.php'</script>";
            } else {
                echo "<script>alert('Incorrect email or password');document.location='../search.php'</script>";
            }
        }
        catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        $pdo = null;
    }
?>