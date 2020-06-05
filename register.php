<?php
// start session
session_start();
$noNavBar= '';
$pageTitle = 'Register';

if (isset($_SESSION['username'])) {
    header('location: index.php'); // redirect to  dashboard page
}

// initialize php file
include 'init.php';

// check if the user coming from the http POST request
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $formErrors = array();
    // form inputs
    $username = $_POST['username'];
    $password = $_POST['pass'];
    $email = $_POST['email'];


    // ******************** Validate form inputs ***************
    // username
    if (isset($_POST['username'])) {

        if (empty($_POST['username'])) {
            $formErrors[] = 'user-empty';
        }else {
            // SANITIZE String
            $filteredUser = filter_var($_POST['username'] , FILTER_SANITIZE_STRING);

            if (strlen($filteredUser) > 1 && strlen($filteredUser) < 4 ) {
                // The Username must be at least 4 characters.
                $formErrors[] = 'username-less';
            }else if (isExist('username', 'users', $_POST['username'])) {
                // This username has already been taken.
                $formErrors[] = 'username-unique';
            }else {
                $username = $filteredUser;
            }
        }
    }
    // Email
    if (isset($_POST['email'])) {
        
        if (empty($_POST['email'])) {
            $formErrors[] = 'email-empty';
        }else {
            // SANITIZE String
            $filteredEmail = filter_var($_POST['email'] , FILTER_SANITIZE_STRING);

            if (filter_var($filteredEmail , FILTER_VALIDATE_EMAIL) != true ) {
                $formErrors[] = 'email-notValid';
            }else {
                $email = $filteredEmail;
            }
        }
    }
    // password
    if (isset($_POST['pass']) && isset($_POST['pass2'])) {
        if (empty($_POST['pass'])) {
            $formErrors[] = 'pass-empty';

        }else {
            if (sha1($_POST['pass'])  !== sha1($_POST['pass2'])) {
                // The password confirmation does not match.
                $formErrors[] = 'pass-notMatch';
            }else {
                $password = sha1($_POST['pass']);
            }
        }
    }
    // check if there is no errors - insert in DB
    if (empty($formErrors)) {
        $stmtInsert = $conn->prepare("INSERT INTO users 
                                     (username, password, email, created_at)
                                     VALUES (:xuser, :xpass, :xemail, now())");

        $stmtInsert->execute(array(
            'xuser' => $username,
            'xpass' => $password,
            'xemail' => $email
        ));

        $count = $stmtInsert->rowCount();
        if ($count > 0) {
            // Successful Inserted Message
            echo "<div class='container'>";
                $msg = "<strong>$count</strong> Congrats, Now You Are Register User";
                redirect2Home('success', $msg, 3 , 'login.php');
            echo "</div>";
        } else {
            // Error Inserted Message - No Data Inserted Yet!
            $msg = "No Data Inserted Yet!";
            redirect2Home('danger', $msg, 3, $_SERVER['HTTP_REFERER']);
        }
    }
   

   
}

?>
<div class="container register-page">
    <div class="register-box">
        <div class="card">
            <div class="card-body register-card-body">
                <p class="register-box-msg">Register a new membership</p>


                <form class="register-form" action="<?php $_SERVER['PHP_SELF']?>" method="POST">
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control 
                                <?php 
                                    if(in_array('user-empty' , $formErrors) ||
                                        in_array('username-less' , $formErrors) ||
                                        in_array('username-unique' , $formErrors) ){echo 'is-invalid'; }?>"
                            placeholder="Username" autocomplete="off" pattern=".{4,}" 
                            title="The Username must be at least 4 characters" autofocus required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <!-- Print form-errors -->
                        <?php
                            if(!empty($formErrors)){
                                if(in_array('user-empty' , $formErrors)){
                                    echo "<span class='invalid-feedback' role='alert'>
                                            <strong>The Username field is required.</strong>
                                        </span>";
                                }
                                if(in_array('username-less' , $formErrors)){
                                    echo "<span class='invalid-feedback' role='alert'>
                                            <strong>The Username must be at least 4 characters.
                                            </strong>
                                        </span>";
                                }
                                if(in_array('username-unique' , $formErrors)){
                                    echo "<span class='invalid-feedback' role='alert'>
                                            <strong>This username has already been taken.</strong>
                                        </span>";
                                }
                            }
                        ?>
                    </div>

                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control 
                            <?php if(in_array('email-empty' , $formErrors) ||
                                        in_array('email-notValid' , $formErrors)){echo 'is-invalid'; }?>"
                            placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        <!-- Print form-errors -->
                        <?php
                            if(!empty($formErrors)){

                                if(in_array('email-empty' , $formErrors)){
                                    echo "<span class='invalid-feedback' role='alert'>
                                            <strong>The Email field is required.</strong>
                                        </span>";
                                }
                                if(in_array('email-notValid' , $formErrors)){
                                    echo "<span class='invalid-feedback' role='alert'>
                                            <strong>The Email not valid.</strong>
                                        </span>";
                                }
                            }
                        ?>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="pass" class="form-control
                                <?php if(in_array('pass-empty' , $formErrors) ||
                                            in_array('pass-notMatch' , $formErrors)){echo 'is-invalid'; }?>"
                            placeholder="At least 8 characters" autocomplete="new-password" minlength="3" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <!-- Print form-errors -->
                        <?php
                            if(!empty($formErrors)){
                                // 
                                if(in_array('pass-empty' , $formErrors)){
                                    echo "<span class='invalid-feedback' role='alert'>
                                            <strong>The password field is required.</strong>
                                        </span>";
                                }
                                if(in_array('pass-notMatch' , $formErrors)){
                                    echo "<span class='invalid-feedback' role='alert'>
                                            <strong>The password confirmation does not match.</strong>
                                        </span>";
                                }
                                
                            }
                        ?>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password"name="pass2" class="form-control" minlength="3" required placeholder="Retype password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                <label for="agreeTerms">
                                    I agree to the <a href="#">terms</a>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="social-auth-links text-center">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i>
                        Sign up using Facebook
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i>
                        Sign up using Google+
                    </a>
                </div>
                <!-- /.social-auth-links -->

                <a href="login.php" class="text-center">I already have a membership</a>
            </div>
            <!-- /.register-card-body -->
        </div>
    </div>
    <!-- /.register-box -->
</div>



<?php include $tpl . 'footer.php'?>