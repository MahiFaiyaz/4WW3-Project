<?php session_start();
    require './database/config.php';
    $dsn = "mysql:host=$servername;dbname=$dbname;charset=UTF8";

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if ((isset($_GET['Library'])) && !empty($_GET['Library'])) {
            try {
                $pdo = new PDO($dsn, $username, $password);
                $stmt = $pdo->prepare("SELECT * FROM Library Where Name = ?");
                $stmt->execute([$_GET['Library']]);
                $library = $stmt->fetch();
            } 
            catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
            $pd0=null;
        }
    } else {echo "Invalid Method";}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include './include/header.php' ?>
    <title><?=$library['Name'] ?></title>
</head>
<body class="main">
    <!-- Container and main div ids are for properly positioning footer at the bottom -->
    <div id="container">
        <div id="main">
            <!-- Adds navigation bar, with a toggle button when collapsed below a medium size screen (720px) -->
            <nav class="navbar navbar-light navbar-expand-md bg-light sticky-top mb-1">
                <?php include './include/navbar.php' ?>
                <div class="collapse navbar-collapse" id="navbar">
                    <div class="navbar-nav">
                        <!-- Pill background to show which is currently active (in this case none)-->
                        <a class="nav-item nav-link text-center text-dark h5 animate__animated animate__fadeInRight" href="search.php">Home</a>
                        <a class="nav-item nav-link text-center text-dark h5 animate__animated animate__fadeInRight" href="registration.php">Register</a>
                        <a class="nav-item nav-link text-center text-dark h5 animate__animated animate__fadeInRight" href="about.php">About</a>
                        <?php include 'loggedIn.php' ?>
                    </div>
                </div>
            </nav>    
            <!-- Title of library -->
            <h1 class="display-6 text-dark bg-light text-center rounded-bottom pb-3">
                <?=$library['Name'] ?>
            </h1>
            <!-- Div with rating and address -->
            <div class="row" style="margin: auto">
                <div class="col-lg-4 col-12 text-center mt-2 px-2 px-lg-3">
                    <div id="map" style="height: 50vh; width: 100%;"></div>
                    <h2 class="bg-dark text-light text-center rounded-pill mt-2">
                    <?php 
                    if ($library['Rating']) {
                        echo $library['Rating'] . " stars";
                    } else {
                        echo "Unrated";
                    }
                    ?>
                    </h2>
                    <p class="bg-dark text-light text-center rounded-pill ">Latitude: <?=$library['Latitude']?>, Longitude: <?=$library['Longitude'] ?></p>
                </div>
                <img src="images/Terryberry.jpg" class="img-fluid mt-2 px-2 col-lg-8 col-12 gx-0 rounded" alt="Terryberry library">
            </div>
            <!-- Review title -->
            <h2 class="display-6 text-dark bg-light text-center col-md-6 col-12 my-3 mx-auto rounded-pill pb-3">
                Reviews
            </h2>
            <!-- Reviews -->
            <?php 
                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    if ((isset($_GET['Library'])) && !empty($_GET['Library'])) {
                        try {
                            $pdo = new PDO($dsn, $username, $password);
                            $stmt = $pdo->prepare("SELECT Id FROM Library WHERE Name = ?");
                            $stmt->bindParam(1, $_GET['Library']);
                            $stmt->execute();
                            $libId = ($stmt->fetch())['Id'];

                            $stmt = $pdo->prepare("SELECT * FROM Reviews Where LibraryId = ?");
                            $results = $stmt->execute([$libId]);
                            $resultsCount = $stmt->rowCount();
                            if ($resultsCount > 0) {
                                while ($row = $stmt->fetch()) {
                                    
                                    $getNameStmt = $pdo->prepare("SELECT * FROM Users Where Id = ?");
                                    $getNameStmt->bindParam(1, $row['UserId']);
                                    $getNameStmt->execute();
                                    $reviewerName = ($getNameStmt->fetch())['Name'];
                                    
                                    ?>
                                    <div class="card text-white bg-secondary mt-2 col-md-8 col-12 mx-auto bg-gradient mb-2">
                                        <div class="card-body col-6 mx-auto w-0 text-start w-100">
                                            <h3><?=$reviewerName?></h3>
                                            <h4><?=$row['Rating'] ?> stars</h4>
                                            <p><?=$row['Review']?>
                                            </p>
                                        </div>
                                    </div>
                                <?php
                                }
                            }
                        } 
                        catch (PDOException $e) {
                            echo "Connection failed: " . $e->getMessage();
                        }
                        $pd0=null;
                    }
                } else {echo "Invalid Method";}
                if (isset($_SESSION['Email']) && !empty($_SESSION['Email'])) { ?>
                    <div class="card text-white bg-secondary mt-2 mb-5 col-md-8 col-12 mx-auto bg-gradient" >
                    <div class="card-body col-6 mx-auto w-0 text-start w-100">
                    <form action="./database/add_review.php" method="GET">
                        <div class="col-md-2 col-4">
                            <label for="libraryRating" class="form-label">Library Rating</label>
                            <select class="form-select" aria-label="Select rating" name="libraryRating" id="libraryRating">
                                <option value="1">1 Star</option>
                                <option value="2">2 Star</option>
                                <option value="3">3 Star</option>
                                <option value="4">4 Star</option>
                                <option selected value="5">5 Star</option>
                            </select>
                        </div>
                        <label for="libraryReview" class="form-label">Library Review</label>
                        <textarea maxlength="2000" id="libraryReview" name="libraryReview" class="form-control mb-3" placeholder="Library Review" rows="4"></textarea>
                        <input type="hidden" id="libraryName" name="libraryName" value=<?=$library['Name']?>>
                        <input type="submit"/>
                    </form>
                    </div>
                </div> <?php
                }?>
        </div>
    </div>
    <?php include './include/footer.php'; include 'login_form.php'; ?>
    <script type=text/javascript> 
        //Map function for individual sample page, initializes center and zoom and creates a markers before calling initMapMain
        function LibraryMap() {
            const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 1,
            center: {lat: <?=$library['Latitude']?>, lng: <?=$library['Longitude']?> },
            maxZoom: 15
            });

            map.setOptions({styles: styles["hide"]});
            var bounds  = new google.maps.LatLngBounds();

            const markers = [
                {
                    coordinates: { lat: <?=$library['Latitude']?>, lng: <?=$library['Longitude']?> },
                    content:
                    '<h5><?=$library['Name']?></h5>' + 
                    '<h6><?php 
                    if ($library['Rating']) {
                        echo $library['Rating'] . " stars";
                    } else {
                        echo "Unrated";
                    }
                    ?></h6>' +
                    '<p>Latitude: <?=$library['Latitude']?>, Longitude: <?=$library['Longitude']?></p>'
                }
            ]
            markers.forEach((marker)=>{
                var Marker = new google.maps.Marker({
                    position: marker.coordinates,
                    map: map
                })
                bounds.extend(Marker.position);
                var infoWindow = new google.maps.InfoWindow({
                    content: marker.content
                })
                Marker.addListener('click', function(){
                    infoWindow.open(map, Marker);
                })
            }) 
            map.fitBounds(bounds);
        }
    </script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnxIv8WOpNBus9nc4vY8kgpQtH1gcDuro&callback=LibraryMap&libraries=&v=weekly"
      async
    ></script>
</body>
</html>