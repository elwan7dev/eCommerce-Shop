<?php
// start session
session_start();
$noNavBar = ''; // this page has no navbar
$pageTitle = 'Login';

if (isset($_SESSION['username'])) {
    header('location: dashboard.php'); // redirect to  dashboard page
}

// initialize php file
include 'init.php';

// check if the user coming from the http POST request
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $hashedPass = sha1($_POST['pass']);
    
    // check if the user exist in database
    $stmt = $conn->prepare("SELECT 
                                user_id, username, password
                            FROM 
                                users
                            WHERE 
                                username=?
                            AND 
                                password=?
                            AND 
                                group_id = 1  
                            LIMIT 1");
                            //group = 1 - retreive admins only
    $stmt->execute(array($username, $hashedPass));
    $row = $stmt->fetch(); //fetch row data from DB - to get userid

    // if (count > 0) this mean that the database contain record about this username
    $count = $stmt->rowCount();
    if ($count > 0) {
        $_SESSION['username'] = $username; // regiter username in session
        $_SESSION['userid'] = $row['user_id']; // register userid in session
        header('location: dashboard.php'); // redirect to  dashboard page
        exit();
        
        
    }
}

?>
<form class="login-form" action="<?php $_SERVER['PHP_SELF']?>" method="POST">
    <h4 class="text-center">Admin Login</h4>
    <input class="form-control" type="text" name="username" placeholder="username" autocomplete="on">
    <input class="form-control" type="text" name="pass" placeholder="password" autocomplete="on">
    <input class="btn btn-primary btn-block" type="submit" value="login">
</form>

<?php include $tpl . 'footer.php'?>