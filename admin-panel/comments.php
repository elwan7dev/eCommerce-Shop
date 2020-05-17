<?php
/**
 * Template page
 */

session_start();

if (isset($_SESSION['username'])) {
    $pageTitle = 'Comments'; //page title to check it for title tag
    include 'init.php'; // initialize php file
    // Page Code here

    // Code page here
    // split page with GET request
    $action = isset($_GET['action']) ? $_GET['action'] : 'manage';

    if ($action == 'manage') {
        echo 'manage';
    }elseif ($action == 'add') {
        echo 'add';
    }elseif ($action == 'insert') {
        echo 'insert';
    }elseif ($action == 'edit') {
        echo 'edit';
    }elseif ($action == 'update') {
        echo 'update';
    }elseif ($action == 'delete') {
        echo 'delete';
    }else {
        header('location: index.php');
    }

    // ./ Code page

    // footer temp
    include $tpl . 'footer.php';
} else {
    header('location: index.php');
    exit();
}
