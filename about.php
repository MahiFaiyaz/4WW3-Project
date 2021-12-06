<?php session_start() ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="description" content="Search page.">
    <meta property="og:title" content="Library About">
    <meta property="og:url" content="http://18.119.43.170/home/about.php" />
    <?php include './include/header.php' ?>
    <title>Library Locator</title>
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
                        <!-- Pill background to show which is currently active -->
                        <a class="nav-item nav-link text-center text-dark h5 animate__animated animate__fadeInRight" href="search.php">Home</a>
                        <a class="nav-item nav-link text-center text-dark h5 animate__animated animate__fadeInRight" href="registration.php">Register</a>
                        <a class="nav-item nav-link text-center text-light h5 rounded-pill bg-dark animate__animated animate__fadeInRight" href="about.php">About</a>
                        <?php include 'loggedIn.php' ?>
                    </div>
                </div>
            </nav>       
            <!-- Title -->
            <h1 class="display-2 text-dark bg-light text-center col-12 col-md-6 mx-auto rounded-pill pb-3">
                About
            </h1>
            <!-- Container with a form within for all library information. Also has a input for image and video -->
            <div class="container-fluid bg-light p-3 rounded col-12 col-md-6 mx-auto text-center">
                <h2>Best website of all time.</h2>
            </div>
        </div>
    </div>
    <?php include './include/footer.php'; include 'login_form.php'; ?>
</body>
</html>