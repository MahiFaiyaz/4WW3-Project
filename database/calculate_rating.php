<?php 
    require './database/config.php';
    $dsn = "mysql:host=$servername;dbname=$dbname;charset=UTF8";
    try {
        $pdo = new PDO($dsn, $username, $password);
        $stmt = $pdo->prepare("SELECT * FROM Reviews");
        $stmt->execute();
        $results = $stmt->fetch();
        $resultsCount = $stmt->rowCount();
        if ($resultsCount > 0) {

        }
        $name = $results['Name'];
        if(strlen($name) > 15) {
            $name = substr($name, 0, 15) . "...";
        }
    }
    catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $pdo=null;

?>