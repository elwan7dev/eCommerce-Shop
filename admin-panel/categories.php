<?php
/**
 * Categories page
 */

session_start();

if (isset($_SESSION['username'])) {
    $pageTitle = ''; //page title to check it for title tag
    include 'init.php'; // initialize php file
    // Page Code here

    // Code page here
    // split page with GET request
    $action = isset($_GET['action']) ? $_GET['action'] : 'manage';

    if ($action == 'manage') {
        echo 'manage';
        echo "<a href='?action=add' class='btn btn-primary'><i class='fas fa-plus'></i> New Category</a>";

    }elseif ($action == 'add') { // ****** start cats-add page
        ?>

<!-- start html componants -->
<h1 class="text-center">Add New Category</h1>
<div class="container" style="width: 70%;">
    <form action="?action=insert" method="POST">
        <!-- start Name & Order in same row field -->
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" autocomplete="off" required="required"
                    placeholder="Category Name">
            </div>
            <div class="form-group col-md-6">
                <label for="Order">Order</label>
                <input type="text" name="order" class="form-control" autocomplete="off"
                    placeholder="Arrange Categories by ordering">
            </div>
        </div>
        <!-- start description field -->
        <div class="form-group">
            <label for="desc">Description</label>
            <input type="test" name="desc" class="form-control" placeholder="Category Description">
        </div>
        <!-- start radio fields button -->
        <div class="form-row">
            <div class="form-group col-md-4">
                <label class="col-form-label">Visibility</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="visible" id="vis-yes" value="1" checked>
                    <label class="form-check-label" for="vis-yes">Yes</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="visible" id="vis-no" value="0">
                    <label class="form-check-label" for="vis-no">No</label>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label class="col-form-label">Comments</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="comments" id="com-yes" value="1" checked>
                    <label class="form-check-label" for="com-yes">Yes</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="comments" id="com-no" value="0">
                    <label class="form-check-label" for="com-no">No</label>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label class="col-form-label">Ads</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ads" id="ads-yes" value="1" checked>
                    <label class="form-check-label" for="ads-yes">Yes</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ads" id="ads-no" value="0">
                    <label class="form-check-label" for="ads-no">No</label>
                </div>
            </div>

        </div>
        <!-- start button field -->
        <input type="submit" value="Add Category" class="btn btn-primary">
    </form>
</div>

<?php
    // ****** end cats-add page ********

    }elseif ($action == 'insert') {  // ****** end cats-insert page ********

        echo "<h1 class='text-center'>Insert Category</h1>";
        echo "<div class='container' style='width: 70%;'>";

        // check if user coming from http POST request to preven    t browseing page directly
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            // get the vars from the form
            $name = $_POST['name'];
            $order = $_POST['order'];
            $desc = $_POST['desc'];
            $visible = $_POST['visible'];
            $comments = $_POST['comments'];
            $ads = $_POST['ads'];

            // validate Form in server side
            // declare empty errors array
            $formErrors = array();
            if (empty($name)) {
                $formErrors[] = "Name Field Can't Be <strong>Empty!</strong>";
            }
            // if there is errors - print alert errors in update page
            if (!empty($formErrors)) {
                foreach ($formErrors as $error) {
                    echo "<div class='alert alert-danger' role='alert'>" . $error . "</div>";
                }
            }
            // check if there is no errors - insert in DB
            if (empty($formErrors)) {
                // check if the category name that coming from Form exist in DB or Not
                // like this " SELECT name FROM categories WHERE name = $name"
                if (!isExist('name', 'categories', $name)) {

                    // Insert user data into the DB
                    // registeration_status = 1 by default bacause the admin adding this users - so, approved
                    $stmt = $conn->prepare("INSERT INTO categories
                                        (name, ordering, description, visibility ,allow_comments , allow_ads, date)
                                        VALUES (:xname, :xorder, :xdesc, :xvisible , :xcomm , :xads , now())");
                    $stmt->execute(array(
                        'xname' => $name,
                        'xorder' => $order,
                        'xdesc' => $desc,
                        'xvisible' => $visible,
                        'xcomm' => $comments,
                        'xads' => $ads,
                    ));

                    $count = $stmt->rowCount();
                    if ($count > 0) {
                        // Successful Inserted Message
                        $msg = "<strong>$count</strong> Record Have Been Inserted";
                        redirect2Home('success', $msg, 3, 'categories.php');
                    } else {
                        // Error Inserted Message - No Data Inserted Yet!
                        $msg = "No Data Inserted Yet!";
                        redirect2Home('info', $msg, 3, $_SERVER['HTTP_REFERER']);
                    }
                } else {
                    // username exist in DB so, print error msg
                    // $_SERVER['HTTP_REFERER'] => previous page
                    redirect2Home('danger', 'ERROR: Invalid Category Name is already existing in DB', 3, $_SERVER['HTTP_REFERER']);
                }
            }

        } else {
            // Error POST Request: You Can't Browse This Page Directly
            $msg = "Error: You Can't Browse This Page Directly";
            redirect2Home('danger', $msg, 6);

        }

        
        echo "</div>"; //end of container div

    }elseif ($action == 'edit') {
        echo 'edit';
    }elseif ($action == 'update') {
        echo 'update';
    }elseif ($action == 'delete') {
        echo 'delete';
    }else {
        header('location: dashboard.php');
    }

    // ./ Code page

    // footer temp
    include $tpl . 'footer.php';
} else {
    header('location: index.php');
    exit();
}