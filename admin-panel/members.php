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
        case 'edit': // ************* Start Member Edit page *******************
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
    <form action="?action=update" method="POST">
        <!-- add userid input here to post it in form add get it in update page   -->
        <input type="hidden" name="userid" value="<?php echo $userid; ?>">

        <!-- start username & password in same row field -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $row['Username']; ?>"
                    autocomplete="off">
            </div>
            <div class="form-group col-md-6">
                <label for="password">Password</label>
                <input type="hidden" name="oldPassword" value="<?php echo $row['Password']; ?>">
                <input type="password" name="newPassword" class="form-control" autocomplete="off">
            </div>
        </div>
        <!-- start email field -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $row['Email']; ?>">
        </div>
        <!-- start Full Name field -->
        <div class="form-group">
            <label for="fullname">Full Name</label>
            <input type="text" name="fullname" class="form-control" value="<?php echo $row['FullName']; ?>">

        </div>
        <!-- start button field -->
        <input type="submit" value="save" class="btn btn-primary">


    </form>
</div>

<?php
} else {
                // Error:No such ID
                echo "  <div class='container' style='width: 70%; margin-top: 50px;'>
                            <div class='alert alert-danger' role='alert'>
                                Error: No Such ID
                            </div>
                         </div>";
            }
            break; // *************** End Member Edit page *****************

        case 'update': // ************* Start Member Update page ***************
            echo "<h1 class='text-center'>Update Member</h1>";
            // check if user coming from http POST request to prevent browseing page directly
            if ($_SERVER['REQUEST_METHOD'] == "POST") {

                // get the vars from the form
                $userId = $_POST['userid'];
                $userName = $_POST['username'];
                $email = $_POST['email'];
                $fullName = $_POST['fullname'];
               

                // password trick
                $pass = empty($_POST['newPassword']) ? $_POST['oldPassword'] : sha1($_POST['newPassword']);
               
                // Update the DB record with this info 
                $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, fullname = ?, password = ?
                                        WHERE userid =?");
                                        //if i used $_SESSION['userid'] instead if $_GET['userid'] = $userId
                                        //fatal error update in current user only
                $stmt->execute(array($userName, $email, $fullName, $pass, $userId)); 
                $count = $stmt->rowCount();

                if ($count > 0) {
                    // Successful Message
                    // echo "[ $count ]" . ' Record Updated';
                    echo "  <div class='container' style='width: 70%;'>
                                <div class='alert alert-success' role='alert'>
                                    <strong>$count</strong>  Record Have Been Updated
                                </div>
                            </div>";
                } else {
                    // Error Message No Data Updated Yet!
                    echo "  <div class='container' style='width: 70%;'>
                                <div class='alert alert-warning' role='alert'>
                                    No Data Updated Yet!
                                </div>
                            </div>";
                }

            } else {
                // Error: You Can't Browse This Page Directly
                echo "  <div class='container' style='width: 70%;'>
                                <div class='alert alert-danger' role='alert'>
                                Error: You Can't Browse This Page Directly
                                </div>
                            </div>";
            }

            break; // ************* Start Member Update page ***************
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