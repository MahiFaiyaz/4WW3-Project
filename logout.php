<?php
    session_start();
    session_destroy();
    echo "<script>alert('You have been successfully logged out');document.location='./search.php'</script>";
?>