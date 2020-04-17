<?php
session_start();


if (isset($_SESSION['username'])) {
    $pageTitle = 'Dashboard';
    include 'init.php'; // initialize php file

    // Page Code here





    
    // foooter temp
    include $tpl . 'footer.php';
} else {
    header('location: index.php');
    exit();
}
