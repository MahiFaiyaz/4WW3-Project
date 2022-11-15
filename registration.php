<!-- Do not start a session, since user does not need to be logged in -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="description" content="Registration page.">
    <meta property="og:title" content="Registration">
    <meta property="og:url" content="http://18.119.43.170/home/registration.php" />
    <!-- Include headers -->
    <?php include './include/header.php' ?>
    <title>Register</title>
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
                        <a class="nav-item nav-link text-center text-dark h5 animate__animated animate__fadeInRight" href="index.php">Home</a>
                        <a class="nav-item nav-link text-center text-dark h5 animate__animated animate__fadeInRight" href="about.php">About</a>
                        <!-- Display nav items based on if the user is loggged in or not -->
                        <?php include './database/loggedIn.php' ?>
                    </div>
                </div>
            </nav>       
            <!-- Title -->
            <h1 class="display-2 text-dark bg-light text-center col-12 col-md-6 mx-auto rounded-pill pb-3">
                Register
            </h1>
            <!-- Creates a div to position properly and a form within that submits to database/create_user -->
            <div class="container-fluid bg-light p-3 rounded col-12 col-md-6 mx-auto">
                <form action="./database/create_user.php" method="POST" id="register" onsubmit="return validate(this)">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" id="firstName" name="firstName" class="form-control mb-3" placeholder="First name"/>
                    
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" id="lastName" name="lastName" class="form-control mb-3" placeholder="Last name"/>
                    
                    <label class="form-label">Gender</label>
                    
                    <!-- Radio buttons -->
                    <div class="container">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" value="1" id="male">
                            <label class="form-check-label" for="male">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" value="2" id="female">
                            <label class="form-check-label" for="female">Female</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" value="3" id="other">
                            <label class="form-check-label" for="other">Other</label>
                        </div>
                    </div>
                    
                    <label for="userEmail" class="form-label mt-3">Email Address</label>
                    <input type="email" id="userEmail" name="userEmail" class="form-control mb-3" placeholder="name@example.com"/>
                    
                    <label for="userPassword" class="form-label">Password</label>
                    <input type="password" id="userPassword" name="userPassword" class="form-control mb-3" placeholder="Password"/>
                    
                    <label for="userBday" class="form-label">Date of Birth</label>
                    <input type="date" id="userBday" name="userBday" class="form-control mb-3" max="<?php echo date('Y-m-d', strtotime("yesterday"));?>"/>
                    
                    <!-- Checkbox -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"  onchange="return validateTOS()" value="" id="TOS" name="TOS">
                        <label class="form-check-label" for="TOS">Agree to terms of services</label>
                    </div>
                    
                    <button type="submit" onclick="pulseOnClick(this)" class="btn btn-light btn-outline-dark mt-4" id="registerBtn" disabled>Register</button>
                    <div id="registerMsg"></div>
                </form>
            </div>
        </div>
    </div>
    <!-- Include footers and a login form (as modal) -->
    <?php include './include/footer.php'; include './database/login_form.php'; ?>
</body>
</html>