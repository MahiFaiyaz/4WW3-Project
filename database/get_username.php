<?php
    $LoggedIn = 'Login';
    echo $LoggedIn;
    require 'config.php';
    $dsn = "mysql:host=$servername;dbname=$dbname;charset=UTF8";

    try {
        $pdo = new PDO($dsn, $username, $password);
        if ($pdo) {
            $sql = "SELECT Name FROM Users";
            $result = $pdo->query($sql);
            $user = $result->fetchAll();
            // echo $user[0];
            print_r($user[0]);
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $pdo = null;

    // if ($conn->connect_error) {
    //     die("Connection fialed while inserting data: " . $conn->connect_error);
    // } else {
    //     $sql = "SELECT Name FROM Users";
    //     $result = $conn->query($sql);

    //     if ($result->num_rows > 0) {
    //         echo $result[0];
    //     }
    //     $conn->close();
    // }

?>