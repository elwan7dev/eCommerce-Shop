<?php
/**
 * Manage members page
 * You can [Add , Edit , Delete] members from here
 *
 */
session_start();
if (isset($_SESSION['username'])) {
    $pageTitle = 'Members';
    include 'init.php'; // initialize php file
    // Page Code here

    // split page with GET request
    $action = isset($_GET['action']) ? $_GET['action'] : 'manage';
    switch ($action) {
        case 'manage':
            echo 'Welcome in manage page';
            break;
        case 'add':
            echo 'Welcome in add page';
            break;
        case 'edit':
            echo 'Welcome in edit page - your id = '. $_SESSION['userid'];
            
            break;
        case 'stats':
            echo 'Welcome in stats page';
            break;
        case 'delete':
            echo 'Welcome in delete page';
            break;
        default:
            echo 'Error 404 : This page not found';
            break;
    }
    

    // footer temp
    include $tpl . 'footer.php';
} else {
    header('location: index.php');
    exit();
}
