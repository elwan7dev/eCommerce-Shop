<?php
session_start();
$pageTitle = 'Dashboard';

if (isset($_SESSION['username'])) {
    // Page Code

    include 'init.php'; // initialize php file

    include $tpl . 'footer.php';
} else {
    header('location: index.php');
    exit();
}
