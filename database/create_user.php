<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['create_token'])){
            if(!empty($_POST['create_token'])){
                if ($_POST['create_token'] == 'asdf2l3j4@rsfj34$1@asd2agjsd'){
                    $servername = "localhost";
                    $username = "root";
                    $password = "";

                    $connection = new mysqli($servername, $username, $password);
                    if ($connection->connect_error) {
                        die("Connection Failed: ". $connection->connect_error);
                    }

                    $sql = "CREATE DATABASE TEST1";
                    if ($connection->query($sql) === TRUE) {
                        echo "Database created successfully.";
                    } else {
                        echo "Error creating database: " . $connection->error;
                    }
                    $connection->close();

                } else {echo "Invalid Acess";}
            } else {echo "Empty Token";}
        } else {echo "No Token Found";}
    } else {echo "Invalid Method";}
?>