<?php
    require 'config.php';
    $dsn = "mysql:host=$servername;dbname=$dbname;charset=UTF8";
    $markers = array();

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if ((isset($_GET['search'])) && !empty($_GET['search'])) {
            if ((isset($_GET['rating'])) && !empty($_GET['rating'])) {
                try {
                    $pdo = new PDO($dsn, $username, $password);
                    $stmt = $pdo->prepare("SELECT * FROM Library WHERE `Name` LIKE ? AND Rating = ?");
                    $search = '%' . $_GET['search'] . '%';
                    $stmt->bindParam(1, $search);
                    $stmt->bindParam(2, $_GET['rating']);
                    $stmt->execute();
                    $resultsCount = $stmt->rowCount();
                    if ($resultsCount > 0) {
                        while ($row = $stmt->fetch()) {
                            $marker = Array('Name'=>$row['Name'], 'Latitude'=>$row['Latitude'], 'Longitude'=>$row['Longitude']);
                            $markers[] = $marker;?>
                            <a class="card text-white bg-dark my-2" href="individual_result.php?Library=<?= $row['Name']?>">
                                <img class="card-img-top" src="images/Concession-1.jpg" alt="<?=$row['Name'] ?>">
                                <div class="card-body">
                                    <h5><?=$row['Name'] ?></h5>
                                    <h6>4 stars</h6>
                                    <p class="card-text">Latitude: <?=$row['Latitude']?>, Longitude: <?=$row['Longitude']?></p>
                                </div>
                            </a>
                            <?php 
                        }
                    } else {
                        echo "<script>alert('No results Found');document.location='search.php'</script>";

                    }
                } catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
                $pdo = null;
            } else {
                try {
                    $pdo = new PDO($dsn, $username, $password);
                    $stmt = $pdo->prepare("SELECT * FROM Library WHERE `Name` LIKE ?");
                    $search = '%' . $_GET['search'] . '%';
                    $stmt->bindParam(1, $search);
                    $stmt->execute();
                    $resultsCount = $stmt->rowCount();
                    if ($resultsCount > 0) {
                        while ($row = $stmt->fetch()) {
                            $marker = Array('Name'=>$row['Name'], 'Latitude'=>$row['Latitude'], 'Longitude'=>$row['Longitude']);
                            $markers[] = $marker;?>
                            <a class="card text-white bg-dark my-2" href="individual_result.php?Library=<?= $row['Name']?>">
                                <img class="card-img-top" src="images/Concession-1.jpg" alt="<?=$row['Name'] ?>">
                                <div class="card-body">
                                    <h5><?=$row['Name'] ?></h5>
                                    <h6>4 stars</h6>
                                    <p class="card-text">Latitude: <?=$row['Latitude']?>, Longitude: <?=$row['Longitude']?></p>
                                </div>
                            </a>
                            <?php 
                        }
                    } else {
                        echo "<script>alert('No results Found');document.location='search.php'</script>";

                    }
                } catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
                $pdo = null;
            }
        } else {
            if ((isset($_GET['rating'])) && !empty($_GET['rating'])) {
                try {
                    $pdo = new PDO($dsn, $username, $password);
                    $stmt = $pdo->prepare("SELECT * FROM Library WHERE Rating = ?");
                    $stmt->bindParam(1, $_GET['rating']);
                    $stmt->execute();
                    $resultsCount = $stmt->rowCount();
                    if ($resultsCount > 0) {
                        while ($row = $stmt->fetch()) {
                            $marker = Array('Name'=>$row['Name'], 'Latitude'=>$row['Latitude'], 'Longitude'=>$row['Longitude']);
                            $markers[] = $marker;?>
                            <a class="card text-white bg-dark my-2" href="individual_result.php?Library=<?= $row['Name']?>">
                                <img class="card-img-top" src="images/Concession-1.jpg" alt="<?=$row['Name'] ?>">
                                <div class="card-body">
                                    <h5><?=$row['Name'] ?></h5>
                                    <h6>4 stars</h6>
                                    <p class="card-text">Latitude: <?=$row['Latitude']?>, Longitude: <?=$row['Longitude']?></p>
                                </div>
                            </a>
                            <?php 
                        }
                    } else {
                        echo "No results found.";

                    }
                } catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
                $pdo = null;
            } else {
                try {
                    $pdo = new PDO($dsn, $username, $password);
                    $stmt = $pdo->prepare("SELECT * FROM Library");
                    $stmt->execute();
                    $resultsCount = $stmt->rowCount();
                    if ($resultsCount > 0) {
                        while ($row = $stmt->fetch()) {
                            $marker = Array('Name'=>$row['Name'], 'Latitude'=>$row['Latitude'], 'Longitude'=>$row['Longitude']);
                            $markers[] = $marker;?>
                            <a class="card text-white bg-dark my-2" href="individual_result.php?Library=<?= $row['Name']?>">
                                <img class="card-img-top" src="images/Concession-1.jpg" alt="<?=$row['Name'] ?>">
                                <div class="card-body">
                                    <h5><?=$row['Name'] ?></h5>
                                    <h6>4 stars</h6>
                                    <p class="card-text">Latitude: <?=$row['Latitude']?>, Longitude: <?=$row['Longitude']?></p>
                                </div>
                            </a>
                            <?php 
                        }
                    } else {
                        echo "No results found.";

                    }
                } catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
                $pdo = null;
            }
        }
    } else {echo "Invalid Mehthod";}
?>

