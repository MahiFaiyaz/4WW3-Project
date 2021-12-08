<?php
    // Start session, and then destroy session (logging user out).
    // If user is on the object submission page, then redirect to home page,
    // otherwise just refrsh the page
    session_start();
    $currentURL = $_POST['currentURL'];
    session_destroy();
    if ($currentURL == '/home/submission.php') {
        header('Location: ../search.php');
    } else { header('Location: ' . $currentURL); }
?>