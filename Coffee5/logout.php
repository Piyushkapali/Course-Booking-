<?php
    session_start();
    session_unset();
    session_destroy();
    ?>
<?php include 'navbar.php'; ?>
<?php
    header('location:login.php');
    ?>