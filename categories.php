<?php
session_start();
$catId = $_GET['page'];
$catName = str_replace('-', ' ' ,$_GET['pagename']) ;
$pageTitle = "Categories | $catName";

// initialize php file
include 'init.php'; 

// get all approved items in specific category 
$items = getAllRows("*", "items" , "WHERE cat_id = $catId" , "AND approval=1");
// Numbers of approved items in specific category
$catItems = countItems('item_id', 'items', "WHERE cat_id=$catId" , "AND approval = 1" );

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
                                        <a href="product.php?id=<?php echo $item['item_id'] ?>">
                                            <img src="layout/images/image.jpg" class="card-img-top" alt="AD Image">
                                        </a>
                                        <div class="card-body">
                                            <a href="product.php?id=<?php echo $item['item_id'] ?>">
                                                <h5 class="product-title"><?php echo $item['name'];?> </h5>
                                            </a>
                                            <p class="product-description"><?php echo $item['description']; ?> </p>
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