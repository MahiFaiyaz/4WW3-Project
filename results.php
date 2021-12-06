<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="description" content="Sample results page.">
    <meta property="og:title" content="Sample Results">
    <meta property="og:url" content="http://18.119.43.170/home/results_sample.php" />
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
                        <a class="nav-item nav-link text-center text-dark h5 animate__animated animate__fadeInRight" href="search.php">Home</a>
                        <a class="nav-item nav-link text-center text-dark h5 animate__animated animate__fadeInRight" href="submission.php">Submit</a>
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
                <?php  include './database/search_results.php' ?>
                </div>
            </div>
            </div>
        </div>
    </div>
    <?php include './include/footer.php'; include 'login_form.php'; ?>
    <script type=text/javascript> 
        // Map function that grabs a PHP array which has coordinates and names and converts it into a javascript object, adds it into the markers array,
        // before passing the vairbale into initMapMain, which is the main function that sets the parameters for the googleMaps API and is called.
        function ResultMap() {
            const center = { lat: 5, lng: 25 };
            const zoom = 1;
            const openMarkers = true;

            markers = [];
            var create_markers = <?php echo json_encode($markers) ?>

            for (var i = 0; i < create_markers.length; i++) {
                test1 = {coordinates : { lat: parseInt(create_markers[i]['Latitude']), lng: parseInt(create_markers[i]['Longitude']) }}
                test1['content'] = '<h5><a href="individual_result.php?Library=' + create_markers[i]['Name'] + '">' + create_markers[i]['Name'] + '</a></h5>' + '<h6>5 stars</h6>' +
                '<p>Latitude: ' + create_markers[i]['Latitude'] + ', Longitude: ' + create_markers[i]['Longitude'] + ' </p>';
                markers.push(test1);
            }
            initMapMain(center, zoom, markers, openMarkers)
        }
    </script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnxIv8WOpNBus9nc4vY8kgpQtH1gcDuro&callback=ResultMap&libraries=&v=weekly"
      async
    ></script>
</body>
</html>