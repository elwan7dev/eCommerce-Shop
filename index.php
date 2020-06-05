<?php
session_start();
$pageTitle = 'Shop';

// initialize php file
include 'init.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   
    <!-- Main content -->
    <section class="content my-5">
        <div class="container">
            <div class="ads">
                <?php
                    $items = getAllRows('*' , 'items' , 'WHERE approval=1');
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
                                                <h5 class="product-title"><?php echo $item['name']; ?> </h5>
                                            </a>
                                            <p class="product-description"><?php echo $item['description']; ?> </p>
                                            <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        echo '</div>';
                            }else {
                                echo "<div class='alert alert-danger' role='alert'>No Items Found</div>";
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