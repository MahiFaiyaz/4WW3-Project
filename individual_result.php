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
                    <h2 class="bg-dark text-light text-center rounded-pill mt-2">3 stars</h2>
                    <p class="bg-dark text-light text-center rounded-pill ">Latitude: <?=$library['Latitude']?>, Longitude: <?=$library['Longitude'] ?></p>
                </div>
                <img src="images/Terryberry.jpg" class="img-fluid mt-2 px-2 col-lg-8 col-12 gx-0 rounded" alt="Terryberry library">
            </div>
            <!-- Review title -->
            <h2 class="display-6 text-dark bg-light text-center col-md-6 col-12 my-3 mx-auto rounded-pill pb-3">
                Reviews
            </h2>
            <!-- Reviews -->
            <div class="card text-white bg-secondary mt-2 col-md-8 col-12 mx-auto bg-gradient mb-2">
                <div class="card-body col-6 mx-auto w-0 text-start w-100">
                    <h3>Jack Ryan</h3>
                    <h4>4 stars</h4>
                    <p>Not the worst library, it's okay. I would consider going again. They have 2 floors, the the 2nd floor is pretty nice.
                        The first floor is a bit cramped so I wouldn't recommend that one.
                    </p>
                </div>
            </div>
            <div class="card text-white bg-secondary mt-2 col-md-8 col-12 mx-auto bg-gradient">
                <div class="card-body col-6 mx-auto w-0 text-start w-100">
                    <h3>John Wick</h3>
                    <h4>1 stars</h4>
                    <p>One of the worst libraries I have ever been to in my life. Cannot believe they have the audacity to call this a library. Barely passes for a building.
                        My day is ruined and my disappointment is immeasurable. I am suing them for crimes against humanity!
                    </p>
                </div>
            </div>
            <div class="card text-white bg-secondary mt-2 col-md-8 col-12 mx-auto bg-gradient">
                <div class="card-body col-6 mx-auto w-0 text-start w-100">
                    <h3>Karen Karenson</h3>
                    <h4>2 stars</h4>
                    <p>Wow I had heard so much good things about this place, but I was so disappointed when I went and they wouldn't serve me food. Apparently they don't serve
                        food in a library. They probably just hate me because I'm better than them. 
                    </p>
                </div>
            </div>
            <div class="card text-white bg-secondary mt-2 mb-5 col-md-8 col-12 mx-auto bg-gradient">
                <div class="card-body col-6 mx-auto w-0 text-start w-100">
                    <h3>Nice Guy</h3>
                    <h4>5 stars</h4>
                    <p>Best library I have been to in the world. If I could give it 10 stars, I would. Go there again??
                        I live there now (but please keep this a secret, the staff don't know I'm living in the basement). 
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php include './include/footer.php'; include 'login_form.php'; ?>
    <script type=text/javascript> 
        //Map function for individual sample page, initializes center and zoom and creates a markers before calling initMapMain
        function LibraryMap() {
            const center = { lat: <?=$library['Latitude']?>, lng: <?=$library['Longitude']?> };
            const zoom = 15;
            const openMarkers = true;

            const markers = [
                {
                    coordinates: { lat: <?=$library['Latitude']?>, lng: <?=$library['Longitude']?> },
                    content:
                    '<h5><?=$library['Name']?></h5>' + 
                    '<h6>3 stars</h6>' +
                    '<p>Latitude: <?=$library['Latitude']?>, Longitude: <?=$library['Longitude']?></p>'
                }
            ]
            initMapMain(center, zoom, markers, openMarkers)
        }
    </script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnxIv8WOpNBus9nc4vY8kgpQtH1gcDuro&callback=LibraryMap&libraries=&v=weekly"
      async
    ></script>
</body>
</html>