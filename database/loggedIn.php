<?php
    // Check if session if in progress
    if (isset($_SESSION['Email']) && !empty($_SESSION['Email'])) {
        // config.php includes database information (username, pass, etc)
        require 'config.php';
        $dsn = "mysql:host=$servername;dbname=$dbname;charset=UTF8";
        try {
            // Try to get Name from Users table with the given session email. If name is too
            // long, then truncate it.
            $pdo = new PDO($dsn, $username, $password);
            $stmt = $pdo->prepare("SELECT * FROM Users Where Email = ?");
            $stmt->bindParam(1, $_SESSION['Email']);
            $stmt->execute();
            $results = $stmt->fetch();
            $name = $results['Name'];
            if(strlen($name) > 15) {
                $name = substr($name, 0, 15) . "...";
            }
        }
        catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        // set pdo to null
        $pdo=null;
        // if user is on the submission then display submission page navigation pill as highlighted
        if ($_SERVER['PHP_SELF'] == '/home/submission.php'){
            echo '<a class="nav-item nav-link text-center text-light h5 rounded-pill bg-dark animate__animated animate__fadeInRight" href="submission.php">Submit</a>';
        } else {
            // otherwise show the submit navigation pill as unselected
            echo '<a class="nav-item nav-link text-center text-dark h5 animate__animated animate__fadeInRight" href="submission.php">Submit</a>';
        }
        ?>
        <!-- Add a button with the users name to show who is currently logged in -->
        <a class="nav-item nav-link text-center text-dark h5 animate__animated animate__fadeInRight" href="#">
        <?php echo "$name"; ?>
        </a>
        <!-- Add a anchor called LogOut, which uses the following script to submit a form with the current URL -->
        <form action="./database/logout.php" method="POST" id="logOutForm">
            <input type="hidden" name="currentURL" value="<?=$_SERVER['REQUEST_URI'] ?>"/>
            <a class="nav-item nav-link text-center text-danger rounded-pill h5 animate__animated animate__fadeInRight" onclick="submitLogOutForm()" href="#">Log Out</a>
        </form>
        <script>
            function submitLogOutForm() {
                document.getElementById("logOutForm").submit();
            }
        </script>
        <?php

    // If user is not logged in
    } else {
        // Abd if they are on the registration page, then show the Register navigation pill as selected
        if ($_SERVER['PHP_SELF'] == '/home/registration.php'){
            echo '<a class="nav-item nav-link text-center text-light h5 rounded-pill bg-dark animate__animated animate__fadeInRight" href="registration.php">Register</a>';
        } else {
            // Otherwise show the Register navigation pill as unselected.
            echo '<a class="nav-item nav-link text-center text-dark h5 animate__animated animate__fadeInRight" href="registration.php">Register</a>';
        }
        ?>
        <!-- Show a navigation link for Login (which brings up a Modal form) -->
        <a class="nav-item nav-link text-center text-primary rounded-pill h5 animate__animated animate__fadeInRight" data-bs-toggle="modal" data-bs-target="#LoginModal" href="#">Login</a>
        <?php
    }
?>