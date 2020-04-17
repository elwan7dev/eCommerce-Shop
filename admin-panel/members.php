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
        case 'edit': // ***************** Member Edit page *******************
            // check if get request user id is numeric & get the integer value of it.
            $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;

            // Select all fields from record depend on this id
            $stmt = $conn->prepare("SELECT * FROM users WHERE userid=? LIMIT 1");
            //execute Query
            $stmt->execute(array($userid)); //if userid are equal- select
            $row = $stmt->fetch(); //fetch row data from DB

            // if there is such ID - show the form
            if ($stmt->rowCount() > 0) {?>

<!-- start html componants -->
<h1 class="text-center">Edit Member</h1>
<div class="container" style="width: 70%;">
    <form>
        <!-- start username & password in same row field -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" value=<?php echo $row['Username']; ?> autocomplete="off">
            </div>
            <div class="form-group col-md-6">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" autocomplete="off">
            </div>
        </div>
        <!-- start email field -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value=<?php echo $row['Email']; ?>>
        </div>
        <!-- start Full Name field -->
        <div class="form-group">
            <label for="fullname">Full Name</label>
            <input type="text" name="fullname" class="form-control" value=<?php echo $row['FullName']; ?>>
        </div>
        <!-- start button field -->
        <input type="button" value="save" class="btn btn-primary">
        
        
    </form>
</div>

<?php
        } else {
                echo "<h1>Error:No such ID</h1>";
            }
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