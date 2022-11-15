<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</head>
<?php
    // Start session and include validate form
    session_start();
    include 'validate_form.php';
    $errors = array();

    // Checks if all input fields are valid
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        validateField($errors, 'loginEmail');
        validateField($errors, 'loginPassword');
        validateField($errors, 'requestURI');
        if (count($errors) == 0) {
            $loginEmail = $_POST['loginEmail'];
            $loginPassword = $_POST['loginPassword'];
            $currentURL = $_POST['requestURI'];
            
            // config.php has database info such as username and password
            require 'config.php';
            $dsn = "mysql:host=$servername;dbname=$dbname;charset=UTF8";
            try {
                // Retrieves information from Users table based on the given email
                $pdo = new PDO($dsn, $username, $password);
                $stmt = $pdo->prepare("SELECT * FROM Users Where Email = ?");
                $stmt->bindParam(1, $loginEmail);
                $stmt->execute();
                $results = $stmt->fetch();
                // If anything is returned, then compares the password entered with the Hashed password in the database
                // If password is verfied, then the session email is set, and if rememberMe is checked, then cookies are set as well.
                if ($results) {
                    if(password_verify($loginPassword, $results['Password'])) {
                        $_SESSION['Email'] = $results['Email'];
                        if((isset($_POST['rememberMe'])) && !empty($_POST['rememberMe'])) {
                            setcookie('Email', $loginEmail, time() + (86400 * 30), "/");
                        } else {
                            setcookie('Email', null, -1, "/");
                        }
                        // If the user is on the registration page when logging in, then redirects to homepage
                        if ($currentURL == '/registration.php') {
                            header('Location: ../index.php');
                        // Otherwise user stays on the current page (just refresh page)
                        } else { header('Location: ' . $currentURL); }
                    } else {
                        // If the password is invalid, show an alert and refresh page
                        echo "<script>alert('Incorrect Password');document.location='$currentURL'</script>";
                    } 
                    // If the email is invalid show alert and refresh page
                } else {echo "<script type='text/javascript'>                    
                      swal({
                        title: 'Error',
                        text: 'Email not found!',
                        icon: 'error'
                      });
                    document.location='$currentURL'
                    </script>
                    ";}                
            }
            catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
            // Set pdo to null;
            $pdo = null;
        } echo "Invalid parameters";
    }
?>