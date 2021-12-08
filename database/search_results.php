<?php
    // get database informatin
    require 'config.php';
    $dsn = "mysql:host=$servername;dbname=$dbname;charset=UTF8";
    $markers = array();

    // If a search request and rating is passed
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if ((isset($_GET['search'])) && !empty($_GET['search'])) {
            if ((isset($_GET['rating'])) && !empty($_GET['rating'])) {
                // If variable is passed with comma, then assume it is latitude and longitude
                $coords = explode(',', $_GET['search']);
                if (count($coords)>1) {
                    // If either of the passed variables are not numeric, then show alert and refresh page
                    if (!is_numeric($coords[0]) || !is_numeric($coords[1])) {
                        echo "<script>alert('No results Found');document.location='search.php'</script>";
                        exit();
                    } 
                    // Otherwise, make a SQL query based on latitude and longitude +/- 5 from the values given, as well as using the rating.
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
                            // If results found then include generate_search
                            include 'generate_search.php';
                        }  else {
                            // Display card saying no libraries were found
                            ?>
                            <a class="card text-white bg-dark my-2">
                            <!-- <img class="card-img-top" src="<?=$imgSource?>" alt="<?=$row['Name'] ?>"> -->
                            <div class="card-body">
                                <h5>No library Found</h5>
                            </div>
                            </a>
                        <?php
                        }
                    } catch (PDOException $e) {
                        echo "Connection failed: " . $e->getMessage();
                    }
                    $pdo = null;
                } else {
                    // If search is not given with comma, assumee its a search by name and arting
                    try {
                        // Make query to library table based on the Name and Rating given
                        $pdo = new PDO($dsn, $username, $password);
                        $stmt = $pdo->prepare("SELECT * FROM Library WHERE `Name` LIKE ? AND Rating = ?");
                        $search = '%' . $_GET['search'] . '%';
                        $stmt->bindParam(1, $search);
                        $stmt->bindParam(2, $_GET['rating']);
                        $stmt->execute();
                        $resultsCount = $stmt->rowCount();
                        if ($resultsCount > 0) {
                            // If results found then include generate_search
                            include 'generate_search.php';
                        }  else {
                            // Display card saying no libraries were found
                            ?>
                            <a class="card text-white bg-dark my-2">
                            <!-- <img class="card-img-top" src="<?=$imgSource?>" alt="<?=$row['Name'] ?>"> -->
                            <div class="card-body">
                                <h5>No library Found</h5>
                            </div>
                            </a>
                        <?php
                        }
                    } catch (PDOException $e) {
                        echo "Connection failed: " . $e->getMessage();
                    }
                    $pdo = null;
                }
            } else {
                // If search doesn't include rating
                $coords = explode(',', $_GET['search']);
                // Check if search has comma (if so then assume its a search by latitude and longitude)
                if (count($coords)>1) {
                    // If either of the passed variables are not numeric, then show alert and refresh page
                    if (!is_numeric($coords[0]) || !is_numeric($coords[1])) {
                        echo "<script>alert('No results Found');document.location='search.php'</script>";
                    } 
                    // Otherwise, make a SQL query based on latitude and longitude +/- 5 from the values given.
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
                            // If results found then include generate_search
                            include 'generate_search.php';
                        }  else {
                            // Display card saying no libraries were found
                            ?>
                            <a class="card text-white bg-dark my-2">
                            <!-- <img class="card-img-top" src="<?=$imgSource?>" alt="<?=$row['Name'] ?>"> -->
                            <div class="card-body">
                                <h5>No library Found</h5>
                            </div>
                            </a>
                        <?php
                        }
                    } catch (PDOException $e) {
                        echo "Connection failed: " . $e->getMessage();
                    }
                    $pdo = null;
                } else {
                    // If search is not using latitude and longitude
                    try {
                        // Make query to library table based on the Name given
                        $pdo = new PDO($dsn, $username, $password);
                        $stmt = $pdo->prepare("SELECT * FROM Library WHERE `Name` LIKE ?");
                        $search = '%' . $_GET['search'] . '%';
                        $stmt->bindParam(1, $search);
                        $stmt->execute();
                        $resultsCount = $stmt->rowCount();
                        if ($resultsCount > 0) {
                            // If results found then include generate_search
                            include 'generate_search.php';
                        }  else {
                            // Display card saying no libraries were found
                            ?>
                            <a class="card text-white bg-dark my-2">
                            <!-- <img class="card-img-top" src="<?=$imgSource?>" alt="<?=$row['Name'] ?>"> -->
                            <div class="card-body">
                                <h5>No library Found</h5>
                            </div>
                            </a>
                        <?php
                        }
                    } catch (PDOException $e) {
                        echo "Connection failed: " . $e->getMessage();
                    }
                    $pdo = null;
                }
            }
        } else {
            // If there is no search term, but only a rating
            if ((isset($_GET['rating'])) && !empty($_GET['rating'])) {
                try {
                    // Make SQl query to the Library database based on the rating given
                    $pdo = new PDO($dsn, $username, $password);
                    $stmt = $pdo->prepare("SELECT * FROM Library WHERE Rating = ?");
                    $stmt->bindParam(1, $_GET['rating']);
                    $stmt->execute();
                    $resultsCount = $stmt->rowCount();
                    if ($resultsCount > 0) {
                        // If results found then include generate_search
                        include 'generate_search.php';
                    }  else {
                        // Display card saying no libraries were found
                        ?>
                        <a class="card text-white bg-dark my-2">
                        <!-- <img class="card-img-top" src="<?=$imgSource?>" alt="<?=$row['Name'] ?>"> -->
                        <div class="card-body">
                            <h5>No library Found</h5>
                        </div>
                        </a>
                    <?php
                    }
                } catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
                $pdo = null;
            } else {
                // If no search or rating given, then query the database for all items in Library
                try {
                    $pdo = new PDO($dsn, $username, $password);
                    $stmt = $pdo->prepare("SELECT * FROM Library");
                    $stmt->execute();
                    $resultsCount = $stmt->rowCount();
                    if ($resultsCount > 0) {
                        // If results found then include generate_search
                        include 'generate_search.php';
                    }  else {
                        // Display card saying no libraries were found
                        ?>
                        <a class="card text-white bg-dark my-2">
                        <!-- <img class="card-img-top" src="<?=$imgSource?>" alt="<?=$row['Name'] ?>"> -->
                        <div class="card-body">
                            <h5>No library Found</h5>
                        </div>
                        </a>
                    <?php
                    }
                } catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
                $pdo = null;
            }
        }
    } else {echo "Invalid Mehthod";}
?>

