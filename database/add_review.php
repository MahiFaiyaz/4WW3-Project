<?php 
    // start sessions, check that request method is a GET, session email is set, and libraryRating, libraryReview, and libraryName are provided
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_SESSION['Email']) && !empty($_SESSION['Email'])) {
            if ((isset($_GET['libraryRating'])) && !empty($_GET['libraryRating'])) {
                if ((isset($_GET['libraryReview'])) && !empty($_GET['libraryReview'])) { 
                    if ((isset($_GET['libraryName'])) && !empty($_GET['libraryName'])) {
                        // config.php includes dbname, servername, username, and password
                        require 'config.php';
                        $dsn = "mysql:host=$servername;dbname=$dbname;charset=UTF8";
                        $libRating = $_GET['libraryRating'];
                        $libReview = $_GET['libraryReview'];
                        $libName = $_GET['libraryName'];
                        try {
                            // try new PDO, prepare statement to retrieve libraryID using the libraryName given
                            $pdo = new PDO($dsn, $username, $password);
                            $stmt = $pdo->prepare("SELECT * FROM Library WHERE `Name` = ?");
                            $stmt->bindParam(1, $libName);
                            $stmt->execute();
                            $library = $stmt->fetch();
                            $libId = $library['Id'];

                            // Retrieve userId using the session email
                            $stmt = $pdo->prepare("SELECT * FROM Users Where Email = ?");
                            $stmt->bindParam(1, $_SESSION['Email']);
                            $stmt->execute();
                            $results = $stmt->fetch();
                            $name = $results['Name'];
                            $userId = $results['Id'];

                            // Insert review into reviews table using the provided information
                            $stmt = $pdo->prepare("INSERT INTO `Reviews` (`LibraryId`, `UserId`, `Review`, `Rating`)
                            VALUES (?, ?, ?, ?)");
                            $stmt->bindParam(1, $libId);
                            $stmt->bindParam(2, $userId);
                            $stmt->bindParam(3, $libReview);
                            $stmt->bindParam(4, $libRating);
                            $stmt->execute();

                            // Select all reviews from the reviews table using the libraryID
                            // Calculate the total ratings, and divide by total amount of reviews
                            // to get the average rating
                            $stmt = $pdo->prepare("SELECT * FROM Reviews WHERE LibraryId = ?");
                            $stmt->bindParam(1, $libId);
                            $stmt->execute();
                            $resultsCount = $stmt->rowCount();
                            $total = 0;
                            if ($resultsCount > 0) {
                                while ($row = $stmt->fetch()) {
                                    $total += $row['Rating'];
                                }
                            }
                            $average = $total/$resultsCount;

                            // Update library table with the newly created Rating 
                            $stmt = $pdo->prepare("UPDATE Library SET Rating = ? WHERE Id = ?");
                            $stmt->bindParam(1, $average);
                            $stmt->bindParam(2, $libId);
                            $stmt->execute();

                            // Refresh page to display new review
                            header('Location: ../individual_result.php?Library=' . $libName );
                            exit();
                        }
                        catch (PDOException $e) {
                            echo "Connection failed: " . $e->getMessage();
                        }
                        // set PDO to null;
                        $pdo=null;
                    } else {echo "Library not found"; }
                } else {echo "No review found"; }
            } else {echo "No rating found"; }
        }  else {echo "You must be logged in"; }
    } else {echo "Invalid Method"; }
?>