<?php
session_start();
$catId = $_GET['page'];
$catName = str_replace('-', ' ' ,$_GET['pagename']) ;
$pageTitle = "Categories | $catName";

// initialize php file
include 'init.php'; 

$items = getItems('cat_id' , $catId);
?>

<div class="container">
    <h1 class ="text-center"> <?php echo $catName  ?> </h1>
    <div class="ads">
        <div class="row">
        
            <?php
                if (! empty($items)) {
                    foreach ($items as $item) { ?>
                        <div class="col-sm-6 col-md-3">
                            <div class="card">
                                <img src="layout/images/image.jpg" class="card-img-top" alt="AD Image">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $item['name'] ?> </h5>
                                    <p class="card-text"><?php echo $item['price'] ?> </p>
                                    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                }else {
                    echo "No Items Found in this cat";
                }

            
            ?>
        </div>
    </div>
    
   

</div>



<?php

include $tpl . 'footer.php'
?>