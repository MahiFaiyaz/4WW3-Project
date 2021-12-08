<!-- Start PHP session -->
<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="description" content="Sample results page.">
    <meta property="og:title" content="Sample Results">
    <meta property="og:url" content="http://18.119.43.170/home/results_sample.php" />
    <!-- Include headers -->
    <?php include './include/header.php' ?>
    <title>Result</title>
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
                        <!-- Pill background to show which is currently active (in this case none)-->
                        <a class="nav-item nav-link text-center text-dark h5 animate__animated animate__fadeInRight" href="search.php">Home</a>
                        <a class="nav-item nav-link text-center text-dark h5 animate__animated animate__fadeInRight" href="about.php">About</a>
                        <!-- Display nav items based on if the user is loggged in or not -->
                        <?php include './database/loggedIn.php' ?>
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
                <!-- Include database/search_results which generates the results -->
                <?php  include './database/search_results.php' ?>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- Include footers and a login form (as modal) -->
    <?php include './include/footer.php'; include './database/login_form.php'; ?>
    <script type=text/javascript> 
        // Map function that grabs a PHP array called $markers, which has coordinates and names of the library and converts it into a javascript object using json_encode (create_markers)
        // That array is then processed, and js objects are created with coordinates and content retrieved from the create_markers array, which is then used by the Google Maps API to generate markers on the search page.
        function ResultMap() {
            const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 1,
            center: {lat: 0, lng: 0},
            maxZoom: 15
            });

            map.setOptions({styles: styles["hide"]});
            var bounds  = new google.maps.LatLngBounds();

            markers = [];
            // convert PHP array into js
            var create_markers = <?php echo json_encode($markers) ?>

            // Loop through array and create marker objects
            for (var i = 0; i < create_markers.length; i++) {
                var rate;
                if (create_markers[i]['Rating']) {
                    rate = create_markers[i]['Rating'] + " stars";
                } else {
                    rate = "Unrated";
                }
                // Create marker with latitude and longitude from library database as well as rating.
                markerToAdd = {coordinates : { lat: parseInt(create_markers[i]['Latitude']), lng: parseInt(create_markers[i]['Longitude']) }}
                markerToAdd['content'] = '<h5><a href="individual_result.php?Library=' + create_markers[i]['Name'] + '">' + create_markers[i]['Name'] + '</a></h5>' + '<h6>' + rate + '</h6>' +
                '<p>Latitude: ' + create_markers[i]['Latitude'] + ', Longitude: ' + create_markers[i]['Longitude'] + ' </p>';
                markers.push(markerToAdd);
            }
            // Extend the bounds of the generated map based on each marker that is added
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
            // Auto zoom and pan the map to display all the markers
            map.fitBounds(bounds);
        }
</script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnxIv8WOpNBus9nc4vY8kgpQtH1gcDuro&callback=ResultMap&libraries=&v=weekly"
      async
    ></script>
</body>
</html>