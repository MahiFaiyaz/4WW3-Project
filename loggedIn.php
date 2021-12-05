<?php
    if (isset($_SESSION['Email'])) {

        require './database/config.php';
        $dsn = "mysql:host=$servername;dbname=$dbname;charset=UTF8";
        try {
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
        echo '<a class="nav-item nav-link text-center text-dark h5 animate__animated animate__fadeInRight" href="#">';
        echo "$name";
        echo '</a>';
        echo '<a class="nav-item nav-link text-center text-dark h5 animate__animated animate__fadeInRight" href="logout.php">Log Out</a>';
    } else {
        echo '<a class="nav-item nav-link text-center text-dark h5 animate__animated animate__fadeInRight" data-bs-toggle="modal" data-bs-target="#LoginModal" href="#">Login</a>';
    }
?>