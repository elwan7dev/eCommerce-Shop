<?php
session_start();
$pageTitle = 'Ads';

// initialize php file
include 'init.php';

if (isset($_SESSION['username']) || isset($_SESSION['admin'])) {
    $profileName = isset($_SESSION['username']) ?  $_SESSION['username'] : $_SESSION['admin']; 

    ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Advertisement</h1>
                </div>
                <!-- breadcrumb -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/eCommerce">Home</a></li>
                        <li class="breadcrumb-item active">Create Ad</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container">
            <!--Create new-ad Box -->
            <div class="card card-primary">
                <div class="card-header">
                    <h5 class="card-title">Create New Ad</h5>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <div class="row new-ad">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <form action="#" method="POST">
                                        <!-- start Name & Price , Image in same row field -->
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="name">Name</label>
                                                <input type="text" name="name" class="form-control live" 
                                                    data-class=".live-name" placeholder="Item's Name" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="price">Price</label>
                                                <input type="tetx" name="price" class="form-control live" required
                                                    data-class=".live-price" placeholder="Item's Price">
                                            </div>

                                        </div>
                                        <!-- start Description field -->
                                        <div class="form-group">
                                            <label for="desc">Description</label>
                                            <textarea name="desc" class="form-control live" required
                                                data-class=".live-desc" placeholder="Item's Description"></textarea>
                                        </div>
                                        <!-- start Full Name field -->
                                        <div class="form-row">
                                            <div class="form-group col-md-8">
                                                <label for="country">Country Made</label>
                                                <input type="text" name="country" class="form-control"
                                                    required="required" placeholder="Country Made In">
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

                                        <div class="form-row">
                                            <div class="form-group col-md-8">
                                                <label for="name">Image</label>
                                                <div class="input-group ">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"
                                                            id="inputGroupFileAddon01">Upload</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="image"
                                                            aria-describedby="inputGroupFileAddon01">
                                                        <label class="custom-file-label"
                                                            for="inputGroupFileAddon01">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
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
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="card item-box live-preview">
                                <span class="price-tag ">
                                    $<span class="live-price"></span>
                                </span>
                                <img src="layout/images/image.jpg" class="card-img-top" alt="AD Image">
                                    <div class="card-body">
                                        <h3 class="card-title live-name" >Title</h3>
                                        <p class="card-text live-desc">desc</p>
                                    </div>
                                    
                                    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->

            <!-- /.new-ad -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /.content -->



</div>
<!-- /.content-wrapper -->

<?php
}else {
    header('location: login.php');
    exit();
}

include $tpl . 'footer.php'
?>