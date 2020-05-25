<?php
session_start();
$pageTitle = 'Profile';

// initialize php file
include 'init.php';

    if (isset($_SESSION['username'])) {
        echo "welcome ". $_SESSION['username'];

    }else {
        header('location: login.php');
        exit();
    }

include $tpl . 'footer.php'
?>