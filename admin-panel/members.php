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
        case 'edit': // Edit page
            echo 'Welcome in edit page - your id = ' . $_SESSION['userid'];?>

<!-- start html componants -->
<h1 class="text-center">Edit Member</h1>
<div class="container">
    <form>
        <!-- start username field -->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="username">Username</label>
            <div class="col-sm-10">
                <input type="text" name="username" class="form-control form-control-lg" autocomplete="off">
            </div>
        </div>
        <!-- start Password field -->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="username">Password</label>
            <div class="col-sm-10">
                <input type="password" name="password" class="form-control form-control-lg" autocomplete="off">
            </div>
        </div>
        <!-- start email field -->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="username">Email</label>
            <div class="col-sm-10">
                <input type="email" name="email" class="form-control form-control-lg">
            </div>
        </div>
        <!-- start Full Name field -->
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="username">Full Name</label>
            <div class="col-sm-10">
                <input type="text" name="fullname" class="form-control form-control-lg">
            </div>
        </div>
        <!-- start username field -->
        <div class="form-group row">
            <div class="col-sm-10">
                <input type="button" value="save" class="btn btn-primary">
            </div>
        </div>
    </form>
</div>

<?php break;
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