<?php
/**
 * Manage members page
 * You can [Add(insert) , Edit(update) , Delete ] members from here
 *
 */
session_start();
if (isset($_SESSION['admin'])) {
    $pageTitle = 'Members'; //page title to check it for title tag
    include 'init.php'; // initialize php file
    // Page Code here

    // split page with GET request
    $action = isset($_GET['action']) ? $_GET['action'] : 'manage';

    switch ($action) {
        case 'manage': // ************* Start Member Manage page [Members page] ***************
            // (Smart way) to create member-pending page that depent on condition (reg_status = 0)
            // if there is GET req  'page' = pending =>>> add this condition to query
            $condition = (isset($_GET['page']) && $_GET['page'] == 'pending') ? "WHERE reg_status = 0" : NULL;
            // retreive all users from DB except admins
            $rows = getRows("*" , "users" , $condition);
            
            ?>

<!-- start html componants -->
<h1 class="text-center">Manage Members</h1>
<div class="container">
    <?php  if (!empty($rows)) { ?>
    <div class="table-responsive">
        <table class="table main-table table-bordered  text-center">
            <thead class="thead-light">
                <tr>
                    <th scope="col">#ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Registerd Date</th>
                    <th scope="col">Controls</th>
                </tr>
            </thead>
            <tbody>
                <?php
            // loop on $rows array and print dynamic data
            foreach ($rows as $row) {
                // trick to change style of pending user row
                $created_at = date("d-m-Y", strtotime($row['created_at']));
                $class = ($row['reg_status'] == 0) ? "class='table-secondary text-muted' title='Pending Member'" : '';

                echo "<tr $class>"; 
                echo "<th scope='row'>" . $row['user_id'] . " </th>";
                echo "<td>" . $row['username'] ; 
                    if ($row['group_id'] == 1) {
                        echo "<span class='admin ' title='admin'><i class='fas fa-award'></i></span> "; 
                    }
                echo "</td>";
                echo "<td>" . $row['email'] . " </td>";
                echo "<td>" . $row['full_name'] . " </td>";
                echo "<td>" . $created_at . " </td>";
                echo "<td>
                            <a href='members.php?action=edit&userid=" . $row['user_id'] . "' class='btn btn-success btn-sm mb-2' title='Edit Member'><i class='fas fa-edit'></i></a>
                            <a href='members.php?action=delete&userid=" . $row['user_id'] . "' class='btn btn-danger btn-sm mb-2 confirm' title='Delete Member'><i class='fas fa-trash-alt'></i></a>";
                if ($row['reg_status'] == 0) {
                    echo "<a href='members.php?action=activate&userid=" . $row['user_id'] . "' class='btn btn-primary btn-sm activate confirm' title='Activate Member'><i class='fas fa-check'></i></a>";
                }
                echo "</td>";
                echo "</tr>";
            }
            ?>

            </tbody>
        </table>
    </div>
        <?php
            }else {
                echo "<div class='alert alert-warning'> No Data Found</div>";
            }
        ?>
    <a href='?action=add' class="btn btn-primary"><i class="fas fa-plus"></i> New Member</a>

</div>

<?php
            
break; // ********* End Member Manage page [Members page] ************

        case 'activate': // ************* start Member activate page ***************
            echo "<h1 class='text-center'>activate Member</h1>";
            echo "<div class='container' style='width: 70%;'>";
            // check if get request user id is numeric & get the integer value of it.
            $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : false;

            // if there is such ID - activate it
            if ($userid != false && isExist('user_id', 'users', $userid)) {
                // prepare Query
                $stmt = $conn->prepare("UPDATE users SET reg_status = 1 WHERE user_id = :xid");
                // bind params
                $stmt->bindParam(':xid', $userid);
                $stmt->execute();
                $count = $stmt->rowCount();

                // Successful deleting Message
                $msg = "<strong>$count</strong> User Activated ";
                redirect2Home('success', $msg, 0, $_SERVER['HTTP_REFERER']);

            } else {
                // Error deleting Message - There Is No Such ID!
                $msg = "There Is No Such ID!";
                redirect2Home('danger', $msg, 3);
            }
            echo "</div>";

            break; // ************* End Member activate page ***************

        case 'add': // ************* Start Member Add page *******************
            ?>
<!-- start html componants -->
<h1 class="text-center">Add New Member</h1>
<div class="container" style="width: 70%;">
    <form action="?action=insert" method="POST">
        <!-- start username & password in same row field -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" autocomplete="off" required="required"
                    placeholder="">
            </div>
            <div class="form-group col-md-6">
                <label for="password">Password</label>
                <input type="password" name="password" class="password form-control" autocomplete="off"
                    required="required" placeholder="">
                <i class="show-pass fas fa-eye"></i>
            </div>
        </div>
        <!-- start email field -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required="required" placeholder="">
        </div>
        <!-- start Full Name field -->
        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="fullname">Full Name</label>
                <input type="text" name="fullname" class="form-control" autocomplete="off" required="required"
                    placeholder="">
            </div>
            <div class="form-group col-md-4">
                <label for="inputState">State</label>
                <select name="state" class="form-control">
                    <option value="User" selected>User</option>
                    <option value="Admin">Admin</option>

                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="trustedCheck">
                <label class="form-check-label" for="radio1">
                    Trusted User
                </label>
            </div>
        </div>
        <!-- start button field -->
        <input type="submit" value="Add Member" class="btn btn-primary">
    </form>
</div>


<?php
break; // ************* End Member Add page *******************

        case 'insert': // ************* Start Member insert page *******************
            echo "<h1 class='text-center'>Insert Member</h1>";
            echo "<div class='container' style='width: 70%;'>";

            // check if user coming from http POST request to prevent browseing page directly
            if ($_SERVER['REQUEST_METHOD'] == "POST") {

                // get the vars from the form
                $userName = $_POST['username'];
                $password = $_POST['password'];
                $email = $_POST['email'];
                $fullName = $_POST['fullname'];
                // password trick
                $hashedPass = sha1($password);
                $groupId = ($_POST['state'] === 'Admin') ? 1 : 0;

                // validate Form in server side
                // declare empty errors array
                $formErrors = array();
                if (empty($userName)) {
                    $formErrors[] = "Username Field Can't Be <strong>Empty!</strong>";
                }
                if (strlen($userName) < 4) {
                    $formErrors[] = "Username Can't Be Less Than <strong> 4 Character</strong>";
                }
                if (empty($email)) {
                    $formErrors[] = "Email Field Can't Be <strong>Empty!</strong>";
                }
                if (empty($fullName)) {
                    $formErrors[] = "Full-name Field Can't Be <strong>Empty!</strong>";
                }
                // if there is errors - print alert errors in update page
                if (!empty($formErrors)) {
                    foreach ($formErrors as $error) {
                        echo "<div class='alert alert-danger' role='alert'>" . $error . "</div>";
                    }
                }
                // check if there is no errors - insert in DB
                if (empty($formErrors)) {
                    // check if the username that coming from Form exist in DB or Not
                    // like this " SELECT username FROM users WHERE username = $userName"
                    if (!isExist('username', 'users', $userName)) {

                        // Insert user data into the DB
                        // registeration_status = 1 by default bacause the admin adding this users - so, approved
                        $stmt = $conn->prepare("INSERT INTO users
                                            (username, password, email, full_name ,group_id , reg_status, created_at)
                                            VALUES (:xuser, :xpass, :xmail, :xname , :xgroup , 1 , now())");
                        $stmt->execute(array(
                            'xuser' => $userName,
                            'xpass' => $hashedPass,
                            'xmail' => $email,
                            'xname' => $fullName,
                            'xgroup' => $groupId,
                        ));

                        $count = $stmt->rowCount();
                        if ($count > 0) {
                            // Successful Inserted Message
                            $msg = "<strong>$count</strong> Record Have Been Inserted";
                            redirect2Home('success', $msg, 3, 'members.php');
                        } else {
                            // Error Inserted Message - No Data Inserted Yet!
                            $msg = "No Data Inserted Yet!";
                            redirect2Home('info', $msg, 3, $_SERVER['HTTP_REFERER']);
                        }
                    } else {
                        // username exist in DB so, print error msg
                        // $_SERVER['HTTP_REFERER'] => previous page
                        redirect2Home('danger', 'ERROR: Invalid Username', 3, $_SERVER['HTTP_REFERER']);
                    }
                }

            } else {
                // Error POST Request: You Can't Browse This Page Directly
                $msg = "Error: You Can't Browse This Page Directly";
                redirect2Home('danger', $msg, 6);

            }
            echo "</div>"; //end of container div

            break; // ************* End Member Insert page *******************

        case 'edit': // ************* Start Member Edit page *******************

            // check if get request user id is numeric & get the integer value of it.
            $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : 0;

            // Select all fields from record depend on this id
            $stmt = $conn->prepare("SELECT * FROM users WHERE user_id=? LIMIT 1");
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
                <input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>"
                    autocomplete="off" required="required">
            </div>
            <div class="form-group col-md-6">
                <label for="password">Password</label>
                <input type="hidden" name="oldPassword" value="<?php echo $row['password']; ?>">
                <input type="password" name="newPassword" class="form-control" autocomplete="new-password"
                    placeholder="Leave Blank If You Don't Want To Reset It">
            </div>
        </div>
        <!-- start email field -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>"
                required="required">
        </div>
        <!-- start Full Name field -->
        <div class="form-group">
            <label for="fullname">Full Name</label>
            <input type="text" name="fullname" class="form-control" value="<?php echo $row['full_name']; ?>"
                required="required">

        </div>
        <!-- start button field -->
        <input type="submit" value="save" class="btn btn-primary">
    </form>
</div>

<?php
} else {
                // Error:There Is No Such ID
                echo "<div class='container' style='width: 70%; margin-top: 50px;'>";
                redirect2Home('danger', 'Error: There Is No Such ID', 6);
                echo "</div>";
            }

            break; // *************** End Member Edit page *****************

        case 'update': // ************* Start Member Update page ***************
            echo "<h1 class='text-center'>Update Member</h1>";
            echo "<div class='container' style='width: 70%;'>";

            // check if user coming from http POST request to prevent browseing page directly
            if ($_SERVER['REQUEST_METHOD'] == "POST") {

                // get the vars from the form
                $userId = $_POST['userid'];
                $userName = $_POST['username'];
                $email = $_POST['email'];
                $fullName = $_POST['fullname'];
                // password trick
                $pass = empty($_POST['newPassword']) ? $_POST['oldPassword'] : sha1($_POST['newPassword']);

                // validate Form in server side
                // declare empty errors array
                $formErrors = array();
                if (empty($userName)) {
                    $formErrors[] = "Username Field Can't Be <strong>Empty!</strong>";
                }
                if (strlen($userName) < 4) {
                    $formErrors[] = "Username Can't Be Less Than <strong> 4 Character</strong>";
                }
                if (empty($email)) {
                    $formErrors[] = "Email Field Can't Be <strong>Empty!</strong>";
                }
                if (empty($fullName)) {
                    $formErrors[] = "Full-name Field Can't Be <strong>Empty!</strong>";
                }
                // if there is errors - print alert errors in update page
                if (!empty($formErrors)) {
                    foreach ($formErrors as $error) {
                        echo "<div class='alert alert-danger' role='alert'>" . $error . "</div>";
                    }
                }

                // if there is no errors - update in DB
                if (empty($formErrors)) {

                    $stmt1 = $conn->prepare("SELECT * FROM users WHERE username = ? AND user_id != ?");
                    $stmt1->execute(array($userName , $userId));
                    $count1 = $stmt1->rowCount();
                    // Check if this username taken or not
                    if ($count1 > 0) {
                        $msg = "This Username has already been taken!";
                        redirect2Home('danger', $msg, 3, $_SERVER['HTTP_REFERER']);
                    } else {
                        // Update the DB record with this info
                    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, full_name = ?, password = ?
                                            WHERE user_id =?");
                    //if i used $_SESSION['userid'] instead if $_GET['userid'] = $userId
                    //fatal error update in current user only
                    $stmt->execute(array($userName, $email, $fullName, $pass, $userId));
                    $count = $stmt->rowCount();

                    if ($count > 0) {
                    // Successful updating Message
                    $msg = "<strong>$count</strong> Record Have Been Updated";
                    redirect2Home('success', $msg, 3, 'members.php');
                    } else {
                    // Error Updating Message - No Data Updated Yet!
                    $msg = "No Data Updated Yet!";
                    redirect2Home('info', $msg, 3, $_SERVER['HTTP_REFERER']);
                    }
                        
                    }
                    
                    

                }

            } else {
                // Error POST Request: You Can't Browse This Page Directly
                $msg = "Error: You Can't Browse This Page Directly";
                redirect2Home('danger', $msg, 6);

            }
            echo "</div>"; //end of container div

            break; // ************* Start Member Update page ***************

        case 'delete': // ************* Start Member Delete page *******************
            echo "<h1 class='text-center'>Delete Member</h1>";
            echo "<div class='container' style='width: 70%;'>";
            // check if get request user id is numeric & get the integer value of it.
            $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ? intval($_GET['userid']) : false;

            // if there is such ID - delete it
            if ($userid != false && isExist('user_id', 'users', $userid)) {
                // prepare Query
                $stmt = $conn->prepare("DELETE FROM users WHERE user_id = :xid");
                // bind params
                $stmt->bindParam(':xid', $userid);
                $stmt->execute();
                $count = $stmt->rowCount();

                // Successful deleting Message
                $msg = "<strong>$count</strong> Record Have Been Deleted";
                redirect2Home('success', $msg, 3, $_SERVER['HTTP_REFERER']);

            } else {
                // Error deleting Message - There Is No Such ID!
                $msg = "There Is No Such ID!";
                redirect2Home('danger', $msg, 3);
            }
            echo "</div>";
            break; // ************* Start Member Delete page *******************
        default:
            header('location: members.php');
            break;
    }

    // footer temp
    include $tpl . 'footer.php';
} else {
    header('location: index.php');
    exit();
}