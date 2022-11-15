<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="description" content="Sample results page.">
    <meta property="og:title" content="Sample Results">
    <meta property="og:url" content="https://librarylocator.mahifaiyaz.ca/results_sample.php" />
    <?php include './include/header.php' ?>
    <title>Result</title>
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
                        <a class="nav-item nav-link text-center text-dark h5 animate__animated animate__fadeInRight" href="index.php">Home</a>
                        <a class="nav-item nav-link text-center text-dark h5 animate__animated animate__fadeInRight" href="registration.php">Register</a>
                        <a class="nav-item nav-link text-center text-dark h5 animate__animated animate__fadeInRight" href="about.php">About</a>
                        <?php include 'loggedIn.php' ?>
                    </div>
                </div>
            </nav>    
            <!-- Title -->
            <h4 class="display-5 text-dark bg-light text-center rounded-pill">
                Results
            </h4>
            <div class="row gx-0" style="margin: auto">
                <!-- Table take 25% of the screen on 720px and larger screen, with other 75% being the map.
                On smaller screens, they are stacked and it shows table (100% width) with the map below it-->
                <div class="col-lg-9 px-lg-3 col-12 gx-0 my-lg-3 my-2 px-lg-5 px-2">
                    <div id="map" style="height: 80vh; width: 100%;"></div>
                </div>
                <div class="col-lg-3 col-10 text-center mx-auto px-2 g-lg-2">
                    <a class="card text-white bg-dark" href="individual_sample.html">
                        <img class="card-img-top" src="images/Terryberry.jpg" alt="Terry Berry Library">
                        <div class="card-body">
                            <h5>Hamilton Public Library - Terryberry Branch</h5>
                            <h6>3 stars</h6>
                            <p class="card-text">100 Mohawk Rd W, Hamilton, ON</p>
                        </div>
                    </a>
                    <a class="card text-white bg-dark mt-2" href="individual_sample.html">
                        <img class="card-img-top" src="images/Turner-Park.jpg" alt="Terry Berry Library">
                        <div class="card-body">
                            <h5>Hamilton Public Library - Turner Park Branch</h5>
                            <h6>5 stars</h6>
                            <p class="card-text">352 Rymal Rd E, Hamilton, ON</p>
                        </div>
                    </a>
                    <a class="card text-white bg-dark mt-2" href="individual_sample.html">
                        <img class="card-img-top" src="images/mohawk.png" alt="Terry Berry Library">
                        <div class="card-body">
                            <h5>Mohawk College Library</h5>
                            <h6>4 stars</h6>
                            <p class="card-text">135 Fennell Ave W, Hamilton, ON</p>
                        </div>
                    </a>
                    <a class="card text-white bg-dark mt-2" href="individual_sample.html">
                        <img class="card-img-top" src="images/Sherwood.jpg" alt="Terry Berry Library">
                        <div class="card-body">
                            <h5>Hamilton Public Library - Sherwood Branch</h5>
                            <h6>3 stars</h6>
                            <p class="card-text">467 Upper Ottawa St, Hamilton, ON</p>
                        </div>
                    </a>
                    <a class="card text-white bg-dark my-2" href="individual_sample.html">
                        <img class="card-img-top" src="images/Concession-1.jpg" alt="Terry Berry Library">
                        <div class="card-body">
                            <h5>Hamilton Public Library - Concession Branch</h5>
                            <h6>4 stars</h6>
                            <p class="card-text">565 Consession St, Hamilton, ON</p>
                        </div>
                    </a>
                </div>
            </div>
            </div>
        </div>
    </div>
    <?php include './include/footer.php'; include 'login_form.php'; ?>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnxIv8WOpNBus9nc4vY8kgpQtH1gcDuro&callback=initMap&libraries=&v=weekly"
      async
    ></script>
</body>
</html>