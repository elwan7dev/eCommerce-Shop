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

    if ($action == 'manage') { /********************** Start items-mamnge page */
        // (Smart way) to create items-pending page that depent on condition (reg_status = 0)
        // if there is GET req  'page' = pending =>>> add this condition to query
        $condition = (isset($_GET['page']) && $_GET['page'] == 'pending') ? "WHERE items.approval = 0" : '';

        // retreive all items from DB - with inerr join  
        $stmt = $conn->prepare("SELECT items.* , categories.name AS cat_name , users.username 
                                FROM items
                                INNER JOIN categories ON  categories.cat_id = items.cat_id
                                INNER JOIN users ON users.user_id = items.member_id
                                $condition     ");
                                
        $stmt->execute();
        // fetch all data and asign in array
        $rows = $stmt->fetchAll();    ?>


<!-- start html componants -->
<h1 class="text-center">Manage Items</h1>
<div class="container">
    <?php  if (count($rows) > 0) { ?>
    <div class="table-responsive">
        <table class="table main-table table-bordered  text-center">
            <thead class="thead-light">
                <tr>
                    <th scope="col">#ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">Categroy</th>
                    <th scope="col">Member</th>
                    <th scope="col">Adding at</th>
                    <th scope="col">Controls</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // loop on $rows array and print dynamic data
                foreach ($rows as $row) {
                    // trick to change style of pending item row
                    $class = ($row['approval'] == 0) ? "class='table-secondary text-muted' title='Pending Item'" : '';

                    echo "<tr $class >"; 
                    echo "<th scope='row'>" . $row['item_id'] . " </th>";
                    echo "<td>" . $row['name'] . " </td>";
                    echo "<td>" . $row['description'] . " </td>";
                    echo "<td>" . $row['price'] . " </td>";
                    echo "<td>" . $row['cat_name'] . " </td>";
                    echo "<td>" . $row['username'] . " </td>";
                    echo "<td>" . $row['created_at'] . " </td>";
                    echo "<td>
                                <a href='items.php?action=edit&itemid=" . $row['item_id'] . "' class='btn btn-success btn-sm mb-2' title='Edit Item'><i class='fas fa-edit'></i></a>
                                <a href='items.php?action=delete&itemid=" . $row['item_id'] . "' class='btn btn-danger btn-sm mb-2 confirm' title='Delete Item'><i class='fas fa-trash-alt'></i></a>";
                    if ($row['approval'] == 0) {
                        echo "<a href='items.php?action=approve&itemid=" . $row['item_id'] . "' class='btn btn-primary btn-sm activate confirm' title='Approve Item'><i class='fas fa-check'></i></a>";
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
    <a href='?action=add' class="btn btn-primary"><i class="fas fa-plus"></i> New Item</a>

</div>

<?php

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
                <label for="member">Member</label>
                <select id="member" name="member" class="form-control" required>
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
            $memberID = $_POST['member'];
            $categoryID = $_POST['category'];

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
            if ($memberID == 0) {
                $formErrors[] = "You Must choose the  <strong>Member</strong>";
            }
            if ($categoryID == 0) {
                $formErrors[] = "You Must choose the  <strong>Category</strong>";
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
                                    (name, price, description, country_made, status , cat_id, member_id, created_at)
                                    VALUES (:xname, :xprice, :xdesc, :xcountry , :xstatus, :xcat, :xmember , now())");
                $stmt->execute(array(
                    'xname' => $name,
                    'xprice' => $price,
                    'xdesc' => $desc,
                    'xcountry' => $country,
                    'xstatus' => $status,
                    'xcat' => $categoryID,
                    'xmember' => $memberID,
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


    }elseif ($action == 'edit') { /************** Start items-edit page */
        // check if get request itemid is numeric & get the integer value of it.
        $itemId = (isset($_GET['itemid']) && is_numeric($_GET['itemid'])) ? intval($_GET['itemid']) : 0;

        // Select all fields from record depend on this id
        $stmt = $conn->prepare("SELECT * FROM items WHERE item_id=? LIMIT 1");
        //execute Query
        $stmt->execute(array($itemId)); //if cat_id are equal- select
        $row = $stmt->fetch(); //fetch row data from DB

        // if there is such ID - show the form
        if ($stmt->rowCount() > 0) {   ?>

<!-- start html componants -->
<h1 class="text-center">Edit Item</h1>
<div class="container" style="width: 70%;">
    <form action="?action=update" method="POST">
        <!-- add itemid input here to post it in form add  to get it in update page   -->
        <input type="hidden" name="itemid" value="<?php echo $itemId; ?>">
        <!-- start Name & Price , Image in same row field -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" required="required"
                    value="<?php echo $row['name']; ?>">
            </div>
            <div class="form-group col-md-6">
                <label for="price">Price</label>
                <input type="tetx" name="price" class="form-control" required="required"
                    value="<?php echo $row['price']; ?>">
            </div>

        </div>
        <!-- start Description field -->
        <div class="form-group">
            <label for="desc">Description</label>
            <input type="text" name="desc" class="form-control" required="required"
                value="<?php echo $row['description']; ?>">
        </div>
        <!-- start Full Name field -->
        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="country">Country Made</label>
                <input type="text" name="country" class="form-control" required="required"
                    value="<?php echo $row['country_made']; ?>">
            </div>
            <div class="form-group col-md-4">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="0">Choose...</option>
                    <option value="1" <?php if($row['status'] == 1){echo 'selected';} ?>>new</option>
                    <option value="2" <?php if($row['status'] == 2){echo 'selected';} ?>>old</option>
                    <option value="3" <?php if($row['status'] == 3){echo 'selected';} ?>>like new</option>
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
                <label for="member">Member</label>
                <select id="member" name="member" class="form-control" required>
                    <option value="0" selected>Choose...</option>
                    <?php
                        $users = getRows('user_id , username' , 'users');
                        foreach ($users as $user) {
                            echo "<option value='". $user['user_id']."'";
                                if($row['member_id'] == $user['user_id']) {echo 'selected';}  //to type selected dynamic
                            echo " >" .$user['username'] . "</option> ";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="category">Category</label>
                <select id="category" name="category" class="form-control" required>
                    <option value="0">Choose...</option>
                    <?php
                        $cats = getRows('cat_id , name' , 'categories');
                        foreach ($cats as $cat) {
                            echo "<option value='". $cat['cat_id']."'";
                                if($row['cat_id'] == $cat['cat_id']) {echo 'selected';} //to type selected dynamic
                            echo " >" .$cat['name'] . "</option> ";
                        }
                    ?>
                </select>
            </div>

        </div>

        <!-- start button field -->
        <input type="submit" value="Save" class="btn btn-primary">
    </form>
</div>
<?php

        }else {
            // Error:There Is No Such ID
            echo "<div class='container' style='width: 70%; margin-top: 50px;'>";
            redirect2Home('danger', 'Error: There Is No Such ID', 3);
            echo "</div>";
        } /*****************End items-edit page */

    }elseif ($action == 'update') { /************* Start items-update  page */

        echo "<h1 class='text-center'>Update Item</h1>";
        echo "<div class='container' style='width: 70%;'>";

        // check if user coming from http POST request to prevent browseing page directly
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            // get the vars from the form
            $itemId = $_POST['itemid'];
            $name = $_POST['name'];
            $price = $_POST['price'];  
            $desc = $_POST['desc'];
            $country = $_POST['country'];
            $status = $_POST['status'];
            $memberID = $_POST['member'];
            $catID = $_POST['category'];
            

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
            if ($memberID == 0) {
                $formErrors[] = "You Must choose the  <strong>Member</strong>";
            }
            if ($catID == 0) {
                $formErrors[] = "You Must choose the  <strong>Category</strong>";
            }
           
            // if there is errors - print alert errors in update page
            if (!empty($formErrors)) {
                foreach ($formErrors as $error) {
                    echo "<div class='alert alert-danger' role='alert'>" . $error . "</div>";
                }
            }

            // if there is no errors - update in DB
            if (empty($formErrors)) {

                // Update the DB record with this info
                $stmt = $conn->prepare("UPDATE items 
                                        SET name =? , price =? , description =? , country_made =? , status =? ,
                                            member_id =? , cat_id =?

                                        WHERE item_id =?");
                //if i used $_SESSION['userid'] instead if $_GET['userid'] = $userId
                //fatal error update in current user only
                $stmt->execute(array(
                    $name, $price, $desc , $country, $status , $memberID , $catID , $itemId));
                $count = $stmt->rowCount();

                if ($count > 0) {
                    // Successful updating Message
                    $msg = "<strong>$count</strong> Record Have Been Updated";
                    redirect2Home('success', $msg, 3, 'items.php');
                } else {
                    // Error Updating Message - No Data Updated Yet!
                    $msg = "No Data Updated Yet!";
                    redirect2Home('info', $msg, 3, $_SERVER['HTTP_REFERER']);
                }

            }

        } else {
            // Error POST Request: You Can't Browse This Page Directly
            $msg = "Error: You Can't Browse This Page Directly";
            redirect2Home('danger', $msg, 6);

        }
        echo "</div>"; //end of container div










    }elseif ($action == 'delete') { /*************** Start items-delete page */
        echo "<h1 class='text-center'>Delete Item</h1>";
        echo "<div class='container' style='width: 70%;'>";
        // check if get request user id is numeric & get the integer value of it.
        $itemId = (isset($_GET['itemid']) && is_numeric($_GET['itemid'])) ? intval($_GET['itemid']) : false;

        // if there is such ID - delete it
        if ($itemId != false && isExist('item_id', 'items', $itemId)) {
            // prepare Query
            $stmt = $conn->prepare("DELETE FROM items WHERE item_id = :xid");
            // bind params
            $stmt->bindParam(':xid', $itemId);
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
    }elseif ($action == 'approve') {
        echo "<h1 class='text-center'>Approved Item</h1>";
        echo "<div class='container' style='width: 70%;'>";
        // check if get request user id is numeric & get the integer value of it.
        $itemId = (isset($_GET['itemid']) && is_numeric($_GET['itemid'])) ? intval($_GET['itemid']) : false;

        // if there is such ID - Approved it
        if ($itemId != false && isExist('item_id', 'items', $itemId)) {
            // prepare Query
            $stmt = $conn->prepare("UPDATE items SET approval = 1 WHERE item_id = :xid");
            // bind params
            $stmt->bindParam(':xid', $itemId);
            $stmt->execute();
            $count = $stmt->rowCount();

            // Successful deleting Message
            $msg = "<strong>$count</strong> Item Approved ";
            redirect2Home('success', $msg, 0, $_SERVER['HTTP_REFERER']);

        } else {
            // Error deleting Message - There Is No Such ID!
            $msg = "There Is No Such ID!";
            redirect2Home('danger', $msg, 3);
        }
        echo "</div>";
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