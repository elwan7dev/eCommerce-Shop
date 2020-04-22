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

    }elseif ($action == 'add') {
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
                <input type="text" name="Order" class="form-control" autocomplete="off"
                    placeholder="Arrange Categories by ordering">
            </div>
        </div>
        <!-- start description field -->
        <div class="form-group">
            <label for="description">Description</label>
            <input type="test" name="description" class="form-control" placeholder="Category Description">
        </div>
        <!-- start radio fields button -->
        <div class="form-row">
            <div class="form-group col-md-4">
                <label class="col-form-label">Visibility</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="Visible" id="vis-yes" value="1" checked>
                    <label class="form-check-label" for="vis-yes">Yes</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="Visible" id="vis-no" value="0">
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
                    <input class="form-check-input" type="radio" name="Comments" id="com-no" value="0">
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





    }elseif ($action == 'insert') {
        echo 'insert';
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