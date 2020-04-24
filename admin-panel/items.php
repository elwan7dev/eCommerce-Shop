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
    }elseif ($action == 'add') {
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
                <input type="text" name="country" class="form-control" autocomplete="off" required="required"
                    placeholder="Country Made In">
            </div>
            <div class="form-group col-md-4">
                <label for="status">Status</label>
                <select id="status">
                    <option selected>Choose...</option>
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

        <!-- start button field -->
        <input type="submit" value="Add Item" class="btn btn-primary">
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
        header('location: index.php');
    }

    // ./ Code page

    // footer temp
    include $tpl . 'footer.php';
} else {
    header('location: index.php');
    exit();
}