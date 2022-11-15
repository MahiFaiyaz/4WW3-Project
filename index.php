<!-- Start Sesssion -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="description" content="Search page.">
    <meta property="og:title" content="Library Locator">
    <meta property="og:url" content="https://librarylocator.mahifaiyaz.ca/index.php" />
    <!-- Include headers -->
    <?php include './include/header.php' ?>
    <title>Library Locator</title>
</head>
<body class="main">
    <!-- Container and main div ids are for properly positioning footer at the bottom -->
    <div id="container">
        <div id="main">
            <!-- Adds navigation bar, with a toggle button when collapsed below a medium size screen (720px) -->
            <nav class="navbar navbar-light navbar-expand-md bg-light sticky-top mb-1">
                <!-- Include navigation items -->
                <?php include './include/navbar.php' ?>
                <div class="collapse navbar-collapse" id="navbar">
                    <div class="navbar-nav">
                        <!-- Pill background to show which is currently active -->
                        <a class="nav-item nav-link text-center text-light h5 rounded-pill bg-dark animate__animated animate__fadeInRight" href="index.php">Home</a>
                        <a class="nav-item nav-link text-center text-dark h5 animate__animated animate__fadeInRight" href="about.php">About</a>
                        <!-- Display nav items based on if the user is loggged in or not -->
                        <?php include './database/loggedIn.php' ?>
                    </div>
                </div>
            </nav>    
            <!-- Positing title and search bar in the middle of the screen -->
            <div class="position-absolute top-50 start-50 translate-middle container-fluid row g-0 justify-content-center">
                <h1 class="display-2 text-dark bg-light text-center col-12 col-md-6 mx-auto rounded-pill pb-3 animate__animated animate__fadeIn">
                    Library Locator
                </h1>
                <!-- Form submits the query to results.php -->
                <form action="results.php" method="GET" class="mt-5">
                    <div class="row g-0">
                        <div class="col-md-2 col-4">
                            <select class="form-select" aria-label="Select rating" name="rating" id="rating">
                                <option value="0">All ratings</option>
                                <option value="1">1 Star</option>
                                <option value="2">2 Star</option>
                                <option value="3">3 Star</option>
                                <option value="4">4 Star</option>
                                <option value="5">5 Star</option>
                              </select>
                        </div>
                        <!-- Search bar and submit button -->
                        <div class="col-8">
                            <input type="text" class="form-control" name="search" id="search" placeholder="Search for a library" value="" aria-label="Search"/>
                        </div>
                        <button type="submit" onclick="pulseOnClick(this)" class="col-md-2 col-12 btn btn-light btn-outline-dark">Search</button>
                    </div>
                </form>
                <button onclick="pulseOnClick(this); getLocation(search)" class="btn btn-light col-md-2 col-12 animate__animated" id="btnLocation"><i class="fa fa-map-marker"> Use My Location</i></button>
            </div>
        </div>
    </div>
    <!-- Include footers and a login form (as modal) -->
    <?php include './include/footer.php'; include './database/login_form.php'; ?>
</body>
</html>