<?php
    require 'config.php';
    $dsn = "mysql:host=$servername;dbname=$dbname;charset=UTF8";
    $markers = array();

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if ((isset($_GET['search'])) && !empty($_GET['search'])) {
            if ((isset($_GET['rating'])) && !empty($_GET['rating'])) {
                $coords = explode(',', $_GET['search']);
                if (count($coords)>1) {
                    if (!is_numeric($coords[0]) || !is_numeric($coords[1])) {
                        echo "<script>alert('No results Found');document.location='search.php'</script>";
                    } 
                    try {
                        $pdo = new PDO($dsn, $username, $password);
                        $stmt = $pdo->prepare("SELECT * FROM Library WHERE Latitude BETWEEN ? AND ? AND Longitude BETWEEN ? AND ? AND Rating = ?");
                        $maxLat = (($coords[0] + 5) <= 90) ? ($coords[0] + 5) : 90;
                        $minLat = (($coords[0] - 5) >= -90) ? ($coords[0] - 5) : -90;
                        $maxLng = (($coords[1] + 5) <= 180) ? ($coords[1] + 5) : 180;
                        $minLng = (($coords[1] + 5) <= -180) ? ($coords[1] + 5) : -180;
                        $stmt->bindParam(1, $minLat);
                        $stmt->bindParam(2, $maxLat);
                        $stmt->bindParam(3, $minLng);
                        $stmt->bindParam(4, $maxLng);
                        $stmt->bindParam(5, $_GET['rating']);
                        $stmt->execute();
                        $resultsCount = $stmt->rowCount();
                        if ($resultsCount > 0) {
                            while ($row = $stmt->fetch()) {
                                $marker = Array('Name'=>$row['Name'], 'Latitude'=>$row['Latitude'], 'Longitude'=>$row['Longitude'], 'Rating'=>$row['Rating']);
                                $markers[] = $marker;
                                if ((isset($row['ImageFilePath'])) && !empty($row['ImageFilePath'])){
                                    $imgSource = 'https://library-finder-library-images.s3.us-east-2.amazonaws.com/' . $row['ImageFilePath']; 
                                }
                                else {
                                    $imgSource = 'https://library-finder-library-images.s3.us-east-2.amazonaws.com/images/Library.jpg';
                                }
                                ?>
                                <a class="card text-white bg-dark my-2" href="individual_result.php?Library=<?= $row['Name']?>">
                                    <img class="card-img-top" src="<?=$imgSource?>" alt="<?=$row['Name'] ?>">
                                    <div class="card-body">
                                        <h5><?=$row['Name'] ?></h5>
                                        <h6><?php 
                                        if ($row['Rating']) {
                                            echo $row['Rating'] . " stars";
                                        } else {
                                            echo "Unrated";
                                        }
                                        ?></h6>
                                        <p class="card-text">Latitude: <?=$row['Latitude']?>, Longitude: <?=$row['Longitude']?></p>
                                    </div>
                                </a>
                                <?php 
                            }
                        }  else {echo "<script>alert('No results Found');document.location='search.php'</script>";}
                    } catch (PDOException $e) {
                        echo "Connection failed: " . $e->getMessage();
                    }
                    $pdo = null;
                } else {
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
                                $marker = Array('Name'=>$row['Name'], 'Latitude'=>$row['Latitude'], 'Longitude'=>$row['Longitude'], 'Rating'=>$row['Rating']);
                                $markers[] = $marker;
                                if ((isset($row['ImageFilePath'])) && !empty($row['ImageFilePath'])){
                                    $imgSource = 'https://library-finder-library-images.s3.us-east-2.amazonaws.com/' . $row['ImageFilePath']; 
                                }
                                else {
                                    $imgSource = 'https://library-finder-library-images.s3.us-east-2.amazonaws.com/images/Library.jpg';
                                }
                                ?>
                                <a class="card text-white bg-dark my-2" href="individual_result.php?Library=<?= $row['Name']?>">
                                    <img class="card-img-top" src="<?=$imgSource?>" alt="<?=$row['Name'] ?>">
                                    <div class="card-body">
                                        <h5><?=$row['Name'] ?></h5>
                                        <h6>                                    <?php 
                                        if ($row['Rating']) {
                                            echo $row['Rating'] . " stars";
                                        } else {
                                            echo "Unrated";
                                        }
                                        ?></h6>
                                        <p class="card-text">Latitude: <?=$row['Latitude']?>, Longitude: <?=$row['Longitude']?></p>
                                    </div>
                                </a>
                                <?php 
                            }
                        }  else {echo "<script>alert('No results Found');document.location='search.php'</script>";}
                    } catch (PDOException $e) {
                        echo "Connection failed: " . $e->getMessage();
                    }
                    $pdo = null;
                }
            } else {
                $coords = explode(',', $_GET['search']);
                if (count($coords)>1) {
                    if (!is_numeric($coords[0]) || !is_numeric($coords[1])) {
                        echo "<script>alert('No results Found');document.location='search.php'</script>";
                    } 
                    try {
                        $pdo = new PDO($dsn, $username, $password);
                        $stmt = $pdo->prepare("SELECT * FROM Library WHERE Latitude BETWEEN ? AND ? AND Longitude BETWEEN ? AND ?");
                        $maxLat = (($coords[0] + 5) <= 90) ? ($coords[0] + 5) : 90;
                        $minLat = (($coords[0] - 5) >= -90) ? ($coords[0] - 5) : -90;
                        $maxLng = (($coords[1] + 5) <= 180) ? ($coords[1] + 5) : 180;
                        $minLng = (($coords[1] + 5) <= -180) ? ($coords[1] + 5) : -180;
                        $stmt->bindParam(1, $minLat);
                        $stmt->bindParam(2, $maxLat);
                        $stmt->bindParam(3, $minLng);
                        $stmt->bindParam(4, $maxLng);
                        $stmt->execute();
                        $resultsCount = $stmt->rowCount();
                        if ($resultsCount > 0) {
                            while ($row = $stmt->fetch()) {
                                $marker = Array('Name'=>$row['Name'], 'Latitude'=>$row['Latitude'], 'Longitude'=>$row['Longitude'], 'Rating'=>$row['Rating']);
                                $markers[] = $marker;
                                if ((isset($row['ImageFilePath'])) && !empty($row['ImageFilePath'])){
                                    $imgSource = 'https://library-finder-library-images.s3.us-east-2.amazonaws.com/' . $row['ImageFilePath']; 
                                }
                                else {
                                    $imgSource = 'https://library-finder-library-images.s3.us-east-2.amazonaws.com/images/Library.jpg';
                                }
                                ?>
                                <a class="card text-white bg-dark my-2" href="individual_result.php?Library=<?= $row['Name']?>">
                                    <img class="card-img-top" src="<?=$imgSource?>" alt="<?=$row['Name'] ?>">
                                    <div class="card-body">
                                        <h5><?=$row['Name'] ?></h5>
                                        <h6>                                    <?php 
                                        if ($row['Rating']) {
                                            echo $row['Rating'] . " stars";
                                        } else {
                                            echo "Unrated";
                                        }
                                        ?></h6>
                                        <p class="card-text">Latitude: <?=$row['Latitude']?>, Longitude: <?=$row['Longitude']?></p>
                                    </div>
                                </a>
                                <?php 
                            }
                        }  else {echo "<script>alert('No results Found');document.location='search.php'</script>";}
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
                                $marker = Array('Name'=>$row['Name'], 'Latitude'=>$row['Latitude'], 'Longitude'=>$row['Longitude'], 'Rating'=>$row['Rating']);
                                $markers[] = $marker;
                                if ((isset($row['ImageFilePath'])) && !empty($row['ImageFilePath'])){
                                    $imgSource = 'https://library-finder-library-images.s3.us-east-2.amazonaws.com/' . $row['ImageFilePath']; 
                                }
                                else {
                                    $imgSource = 'https://library-finder-library-images.s3.us-east-2.amazonaws.com/images/Library.jpg';
                                }
                                ?>
                                <a class="card text-white bg-dark my-2" href="individual_result.php?Library=<?= $row['Name']?>">
                                    <img class="card-img-top" src="<?=$imgSource?>" alt="<?=$row['Name'] ?>">
                                    <div class="card-body">
                                        <h5><?=$row['Name'] ?></h5>
                                        <h6>                                    <?php 
                                        if ($row['Rating']) {
                                            echo $row['Rating'] . " stars";
                                        } else {
                                            echo "Unrated";
                                        }
                                        ?></h6>
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
                            $marker = Array('Name'=>$row['Name'], 'Latitude'=>$row['Latitude'], 'Longitude'=>$row['Longitude'], 'Rating'=>$row['Rating']);
                            $markers[] = $marker;
                            if ((isset($row['ImageFilePath'])) && !empty($row['ImageFilePath'])){
                                $imgSource = 'https://library-finder-library-images.s3.us-east-2.amazonaws.com/' . $row['ImageFilePath']; 
                            }
                            else {
                                $imgSource = 'https://library-finder-library-images.s3.us-east-2.amazonaws.com/images/Library.jpg';
                            }
                            ?>
                            <a class="card text-white bg-dark my-2" href="individual_result.php?Library=<?= $row['Name']?>">
                                <img class="card-img-top" src="<?=$imgSource?>" alt="<?=$row['Name'] ?>">
                                <div class="card-body">
                                    <h5><?=$row['Name'] ?></h5>
                                    <h6>                                    <?php 
                                    if ($row['Rating']) {
                                        echo $row['Rating'] . " stars";
                                    } else {
                                        echo "Unrated";
                                    }
                                    ?></h6>
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
                    $stmt = $pdo->prepare("SELECT * FROM Library");
                    $stmt->execute();
                    $resultsCount = $stmt->rowCount();
                    if ($resultsCount > 0) {
                        while ($row = $stmt->fetch()) {
                            $marker = Array('Name'=>$row['Name'], 'Latitude'=>$row['Latitude'], 'Longitude'=>$row['Longitude'], 'Rating'=>$row['Rating']);
                            $markers[] = $marker;
                            if ((isset($row['ImageFilePath'])) && !empty($row['ImageFilePath'])){
                                $imgSource = 'https://library-finder-library-images.s3.us-east-2.amazonaws.com/' . $row['ImageFilePath']; 
                            }
                            else {
                                $imgSource = 'https://library-finder-library-images.s3.us-east-2.amazonaws.com/images/Library.jpg';
                            }
                            ?>
                            <a class="card text-white bg-dark my-2" href="individual_result.php?Library=<?= $row['Name']?>">
                                <img class="card-img-top" src="<?=$imgSource?>" alt="<?=$row['Name'] ?>">
                                <div class="card-body">
                                    <h5><?=$row['Name'] ?></h5>
                                    <h6>
                                    <?php 
                                    if ($row['Rating']) {
                                        echo $row['Rating'] . " stars";
                                    } else {
                                        echo "Unrated";
                                    }
                                    ?>
                                    </h6>
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
        }
    } else {echo "Invalid Mehthod";}
?>

