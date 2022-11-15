<!-- Start Session -->
<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="description" content="Submit new library page.">
    <meta property="og:title" content="Library Submission">
    <meta property="og:url" content="https://librarylocator.mahifaiyaz.ca/submission.php" />
    <!-- Include headers -->
    <?php include './include/header.php' ?>
    <title>Library Submission</title>
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
                        <a class="nav-item nav-link text-center text-dark h5 animate__animated animate__fadeInRight" href="search.php">Home</a>
                        <a class="nav-item nav-link text-center text-dark h5 animate__animated animate__fadeInRight" href="about.php">About</a>
                        <!-- Display nav items based on if the user is loggged in or not -->
                        <?php include './database/loggedIn.php' ?>
                    </div>
                </div>
            </nav>       
            <!-- Title -->
            <h1 class="display-2 text-dark bg-light text-center col-12 col-md-6 mx-auto rounded-pill pb-3">
                Submit library
            </h1>
            <!-- Container with a form within for all library information. Also has a input for image and video, submits to database/add_library -->
            <div class="container-fluid bg-light p-3 rounded col-12 col-md-6 mx-auto">
                <form action="./database/add_library.php" method="POST" enctype="multipart/form-data">
                    <label for="libraryName" class="form-label">Library Name</label>
                    <input type="text" maxlength="255" pattern="[A-Z][A-za-z\-\s\(\)]*" title="First letter must be capitalized, only [- , (  , )] special characters are allowed. Max length of 255" 
                    id="libraryName" name="libraryName" class="form-control mb-3" placeholder="Library name" required/>

                    <label for="Latitude" class="form-label">Latitude</label>
                    <button onclick="getLocation(autoSetLat); pulseOnClick(this)" type="button" class="btn btn-light btn-sm btn-outline-dark animate__animated">Auto Set</button>
                    <input type="number" max="90" min="-90" step="any" id="Latitude" name="Latitude" class="form-control mb-3" placeholder="Ex. 43.653225" required/>

                    <label for="Longitude" class="form-label">Longitude</label>
                    <button onclick="getLocation(autoSetLong); pulseOnClick(this)" type="button" class="btn btn-light btn-sm btn-outline-dark animate__animated">Auto Set</button>
                    <input type="number" max="180" min="-180" step="any" id="Longitude" name="Longitude" class="form-control mb-3" placeholder="Ex. -79.383186" required/>
                    
                    <label for="libraryDesc" class="form-label">Library Description</label>
                    <textarea maxlength="2000" id="libraryDesc" name="libraryDesc" class="form-control mb-3" placeholder="Library Description" rows="4"></textarea>
                    
                    <label for="libraryImg" class="form-label">Library Image</label>
                    <input type="file" id="libraryImg" name="libraryImg" class="form-control file mb-3" accept=".jpg, .png, .jpeg" ></textarea>
                    
                    <label for="libraryVid" class="form-label">Library Video</label>
                    <input type="file" id="libraryVid" name="libraryVid" class="form-control file mb-3" accept=".mp4, .mov, .wmv, .avi, .mkv, .mpeg-2"></textarea>
                    
                    <button type="submit" onclick="shakeOnClick(this)" class="btn btn-light btn-outline-dark mt-3 animate__animated">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Include footers and a login form (as modal) -->
    <?php include './include/footer.php'; include './database/login_form.php'; ?>
</body>
</html>