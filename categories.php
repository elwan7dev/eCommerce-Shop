<?php
session_start();
$catId = $_GET['page'];
$catName = str_replace('-', ' ' ,$_GET['pagename']) ;
$pageTitle = "Categories | $catName";

// initialize php file
include 'init.php'; 

$items = getItems('cat_id' , $catId);
// Numbers of items in specific category
$catItems = countItems('item_id', 'items', "WHERE cat_id="."$catId"." " );

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <section class="content-header cat-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h1><?php echo $catName; ?>     </h1> 
                    <span class="badge badge-primary"><?php echo $catItems ?> Items Found</span>
                </div>
                <!-- breadcrumb -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/eCommerce">Home</a></li>
                        <li class="breadcrumb-item active"><?php echo $catName  ?></li>
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
            <div class="ads">
                <?php
                    if (! empty($items)) {
                        echo '<div class="row">';
                            foreach ($items as $item) { ?>
                                <div class="col-sm-6 col-md-3">
                                    <div class="card item-box">
                                        <span class="price-tag "><?php echo '$'. $item['price']; ?></span>
                                        <img src="layout/images/image.jpg" class="card-img-top" alt="AD Image">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $item['name']; ?> </h5>
                                            <p class="card-text"><?php echo $item['description']; ?> </p>
                                            <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                        echo '</div>';
                    }else {
                        echo "<div class='alert alert-danger' role='alert'>No Items Found in this cat</div>";
                    }
                ?>
            </div>
            <!-- /. ads div -->
        </div>
        <!-- ./container -->
    </section>
</div>



<?php

include $tpl . 'footer.php'
?>