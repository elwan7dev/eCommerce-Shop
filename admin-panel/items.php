<?php
/**
 * items page
 */

session_start();

if (isset($_SESSION['username'])) {
    $pageTitle = 'Items'; //page title to check it for title tag
    include 'init.php'; // initialize php file
    // Page Code here

    // Code page here
    // split page with GET request
    $action = isset($_GET['action']) ? $_GET['action'] : 'manage';

    if ($action == 'manage') {
        echo 'manage';
        echo "<a href='?action=add' class='btn btn-primary btn-sm' > Add New Item</a>";


    }elseif ($action == 'add') { /***************** Start items-add page */
        ?>

<!-- start html componants -->
<h1 class="text-center">Add New Item</h1>
<div class="container" style="width: 70%;">
    <form action="?action=insert" method="POST">
        <!-- start Name & Price , Image in same row field -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" required="required" placeholder="Item's Name">
            </div>
            <div class="form-group col-md-6">
                <label for="price">Price</label>
                <input type="tetx" name="price" class="form-control" required="required" placeholder="Item's Price">
            </div>

        </div>
        <!-- start Description field -->
        <div class="form-group">
            <label for="desc">Description</label>
            <input type="text" name="desc" class="form-control" required="required" placeholder="Item's Description">
        </div>
        <!-- start Full Name field -->
        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="country">Country Made</label>
                <input type="text" name="country" class="form-control" required="required"
                    placeholder="Country Made In">
            </div>
            <div class="form-group col-md-4">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="0" selected>Choose...</option>
                    <option value="1">new</option>
                    <option value="2">old</option>
                    <option value="3">like new</option>
                </select>
            </div>

        </div>
        <div class="form-group">
            <label for="name">Image</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="image" aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="inputGroupFileAddon01">Choose file</label>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="memeber">Member</label>
                <select id="memeber" name="memeber" class="form-control" required>
                    <option value="0" selected>Choose...</option>
                    <?php
                        $users = getRows('user_id , username' , 'users');
                        foreach ($users as $user) {
                            echo "<option value='". $user['user_id']."' >" .$user['username'] . "</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="category">Category</label>
                <select id="category" name="category" class="form-control" required>
                    <option value="0" selected>Choose...</option>
                    <?php
                        $cats = getRows('cat_id , name' , 'categories');
                        foreach ($cats as $cat) {
                            echo "<option value='". $cat['cat_id']."' >" .$cat['name'] . "</option>";
                        }
                    ?>
                </select>
            </div>

        </div>

        <!-- start button field -->
        <input type="submit" value="Add Item" class="btn btn-primary">
    </form>
</div>

<?php

    }elseif ($action == 'insert') { /******************** Start items-insert page */
        echo "<h1 class='text-center'>Insert Item</h1>";
        echo "<div class='container' style='width: 70%;'>";

        // check if user coming from http POST request to preven    t browseing page directly
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            // get the vars from the form
            $name = $_POST['name'];
            $price = $_POST['price'];  
            $desc = $_POST['desc'];
            $country = $_POST['country'];
            $status = $_POST['status'];

            // validate Form in server side
            // declare empty errors array
            $formErrors = array();
            if (empty($name)) {
                $formErrors[] = "Username Field Can't Be <strong>Empty!</strong>";
            }
            if (strlen($name) < 4) {
                $formErrors[] = "Username Can't Be Less Than <strong> 4 Character</strong>";
            }
            if (empty($price)) {
                $formErrors[] = "Price Field Can't Be <strong>Empty!</strong>";
            }
            if (empty($desc)) {
                $formErrors[] = "Description Field Can't Be <strong>Empty!</strong>";
            }
            if (empty($country)) {
                $formErrors[] = "Country Field Can't Be <strong>Empty!</strong>";
            }
            if ($status == 0) {
                $formErrors[] = "You Must choose the  <strong>Status</strong>";
            }
            
            // if there is errors - print alert errors in update page
            if (!empty($formErrors)) {
                foreach ($formErrors as $error) {
                    echo "<div class='alert alert-danger' role='alert'>" . $error . "</div>";
                }
            }
            // check if there is no errors - insert in DB
            if (empty($formErrors)) {
                
                // Insert user data into the DB
                // registeration_status = 1 by default bacause the admin adding this users - so, approved
                $stmt = $conn->prepare("INSERT INTO items
                                    (name, price, description, country_made, status , created_at)
                                    VALUES (:xname, :xprice, :xdesc, :xcountry , :xstatus , now())");
                $stmt->execute(array(
                    'xname' => $name,
                    'xprice' => $price,
                    'xdesc' => $desc,
                    'xcountry' => $country,
                    'xstatus' => $status,
                ));

                $count = $stmt->rowCount();
                if ($count > 0) {
                    // Successful Inserted Message
                    $msg = "<strong>$count</strong> Record Have Been Inserted";
                    redirect2Home('success', $msg, 3, 'items.php');
                } else {
                    // Error Inserted Message - No Data Inserted Yet!
                    $msg = "No Data Inserted Yet!";
                    redirect2Home('info', $msg, 3, $_SERVER['HTTP_REFERER']);
                }
                
            }

        } else {
            // Error POST Request: You Can't Browse This Page Directly
            $msg = "Error: You Can't Browse This Page Directly";
            redirect2Home('danger', $msg, 6);

        }
        echo "</div>"; //end of container div
        
        /********* End items-insert page */


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