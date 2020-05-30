<?php
// start session
session_start();
$noNavBar= '';
$pageTitle = 'Login';

if (isset($_SESSION['username'])) {
    header('location: index.php'); // redirect to  homepage page
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
                            LIMIT 1");
                            //group = 1 - retreive admins only
    $stmt->execute(array($username, $hashedPass));
    $row = $stmt->fetch(); //fetch row data from DB - to get userid

    // if (count > 0) this mean that the database contain record about this username
    $count = $stmt->rowCount();
    if ($count > 0) {
        $_SESSION['username'] = $username; // regiter username in session
        $_SESSION['userid'] = $row['user_id']; // register userid in session
        header('location: index.php'); // redirect to  home-page website
        exit();
    }
}

?>
<div class="container login-page">
    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <form class="login-form" action="<?php $_SERVER['PHP_SELF']?>" method="POST">
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username" autocomplete="off" autofocus required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="pass" class="form-control" placeholder="Password" autocomplete="new-password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="social-auth-links text-center mb-3">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                    </a>
                </div>
                <!-- /.social-auth-links -->

                <p class="mb-1">
                    <a href="#">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="register.php" class="text-center">Register a new membership</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
</div>



<?php include $tpl . 'footer.php'?>