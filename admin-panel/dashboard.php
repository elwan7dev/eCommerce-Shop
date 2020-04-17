<?php
session_start();
if (isset($_SESSION['username'])) {
    // Page Code
    include 'init.php';

    include $tpl . 'footer.php';
} else {
    header('location: index.php');
    exit();
}
