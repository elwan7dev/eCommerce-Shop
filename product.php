<?php
session_start();
$pageTitle ='Prodcut';
// initialize php file
include 'init.php';

// check if get request itemid is numeric & get the integer value of it.
$itemId = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;

// Select all fields from record depend on this id
$stmtItem = $conn->prepare("SELECT items.* , categories.name AS cat_name , users.username
                            FROM items
                            INNER JOIN categories ON categories.cat_id = items.cat_id
                            INNER JOIN users ON users.user_id = items.member_id
                            WHERE item_id=? LIMIT 1");
//execute Query
$stmtItem->execute(array($itemId)); //if cat_id are equal- select
$item = $stmtItem->fetch(); //fetch row data from DB



// Category link actions 
$pageName = str_replace(' ', '-' , $item['cat_name']);
$page = $item['cat_id'];

// Format item created-at
$createdAt = date('D, d M Y' , strtotime($item['created_at']));


// if there is such ID - show the form
if ($stmtItem->rowCount() > 0) {

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>E-commerce</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">E-commerce</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container">
            <div class="row e-commerce">
                <!-- Default box -->
                <div class="col-md-10">
                    <div class="card card-solid ">
                        <div class="card-body">
                            <div class="row product-box mb-4">
                                <!-- col image -->
                                <div class="col-12 col-sm-6">
                                    <h3 class="d-inline-block d-sm-none"><?php echo $item['name']; ?></h3>
                                    <div class="col-12">
                                        <img src="layout/images/prod-1.jpg" class="product-image" alt="Product Image">
                                    </div>
                                    <div class="col-12 product-image-thumbs">
                                        <div class="product-image-thumb active"><img src="layout/images/prod-1.jpg"
                                                alt="Product Image"></div>
                                        <div class="product-image-thumb"><img src="layout/images/prod-2.jpg"
                                                alt="Product Image"></div>
                                        <div class="product-image-thumb"><img src="layout/images/prod-3.jpg"
                                                alt="Product Image"></div>
                                        <div class="product-image-thumb"><img src="layout/images/prod-4.jpg"
                                                alt="Product Image"></div>.
                                        <div class="product-image-thumb"><img src="layout/images/prod-5.jpg"
                                                alt="Product Image"></div>
                                    </div>
                                </div>
                                <!-- col desc -->
                                <div class="col-12 col-sm-6">
                                    <h3 class="my-3"><?php echo $item['name']; ?>
                                        <small>by
                                            <?php
                                                echo "<a href='#'> ".$item['username']."</a>" . ', '; 
                                                echo "<a href='categories.php?page=".$page."&pagename=".$pageName."'>"
                                                    . $item['cat_name']."</a>"; 
                                            ?>
                                        </small>
                                        <!-- <div class="date"></div> -->
                                        <small class='date text-muted'><?php echo $createdAt; ?></small>
                                    </h3>

                                    <p><?php echo $item['description'] ?></p>

                                    <hr>
                                    <h4>Available Colors</h4>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-default text-center active">
                                            <input type="radio" name="color_option" id="color_option1"
                                                autocomplete="off" checked="">
                                            Green
                                            <br>
                                            <i class="fas fa-circle fa-2x text-green"></i>
                                        </label>
                                        <label class="btn btn-default text-center">
                                            <input type="radio" name="color_option" id="color_option2"
                                                autocomplete="off">
                                            Blue
                                            <br>
                                            <i class="fas fa-circle fa-2x text-blue"></i>
                                        </label>
                                        <label class="btn btn-default text-center">
                                            <input type="radio" name="color_option" id="color_option3"
                                                autocomplete="off">
                                            Purple
                                            <br>
                                            <i class="fas fa-circle fa-2x text-purple"></i>
                                        </label>
                                        <label class="btn btn-default text-center">
                                            <input type="radio" name="color_option" id="color_option4"
                                                autocomplete="off">
                                            Red
                                            <br>
                                            <i class="fas fa-circle fa-2x text-red"></i>
                                        </label>
                                        <label class="btn btn-default text-center">
                                            <input type="radio" name="color_option" id="color_option5"
                                                autocomplete="off">
                                            Orange
                                            <br>
                                            <i class="fas fa-circle fa-2x text-orange"></i>
                                        </label>
                                    </div>

                                    <h4 class="mt-3">Size <small>Please select one</small></h4>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-default text-center">
                                            <input type="radio" name="color_option" id="color_option1"
                                                autocomplete="off">
                                            <span class="text-xl">S</span>
                                            <br>
                                            Small
                                        </label>
                                        <label class="btn btn-default text-center">
                                            <input type="radio" name="color_option" id="color_option1"
                                                autocomplete="off">
                                            <span class="text-xl">M</span>
                                            <br>
                                            Medium
                                        </label>
                                        <label class="btn btn-default text-center">
                                            <input type="radio" name="color_option" id="color_option1"
                                                autocomplete="off">
                                            <span class="text-xl">L</span>
                                            <br>
                                            Large
                                        </label>
                                        <label class="btn btn-default text-center">
                                            <input type="radio" name="color_option" id="color_option1"
                                                autocomplete="off">
                                            <span class="text-xl">XL</span>
                                            <br>
                                            Xtra-Large
                                        </label>
                                    </div>

                                    <div class="bg-gray py-2 px-3 mt-4">
                                        <h2 class="mb-0">
                                            <?php echo '$' . $item['price']; ?>
                                        </h2>
                                        <h4 class="mt-0">
                                            <small>Ex Tax: <?php echo '$' . $item['price']; ?> </small>
                                        </h4>
                                    </div>

                                    <div class="mt-4">
                                        <div class="btn btn-primary btn-lg btn-flat">
                                            <i class="fas fa-cart-plus fa-lg mr-2"></i>
                                            Add to Cart
                                        </div>

                                        <div class="btn btn-default btn-lg btn-flat">
                                            <i class="fas fa-heart fa-lg mr-2"></i>
                                            Add to Wishlist
                                        </div>
                                    </div>

                                    <div class="mt-4 product-share">
                                        <a href="#" class="text-gray">
                                            <i class="fab fa-facebook-square fa-2x"></i>
                                        </a>
                                        <a href="#" class="text-gray">
                                            <i class="fab fa-twitter-square fa-2x"></i>
                                        </a>
                                        <a href="#" class="text-gray">
                                            <i class="fas fa-envelope-square fa-2x"></i>
                                        </a>
                                        <a href="#" class="text-gray">
                                            <i class="fas fa-rss-square fa-2x"></i>
                                        </a>
                                    </div>

                                </div>
                            </div>
                            <hr>

                            <!-- comment row -->
                            <div class="row mb-4" id="comment">
                                <div class="col w-100 ">
                                    <?php if (isset($_SESSION['username'])) { 
                    
                                    
                                    if ($_SERVER['REQUEST_METHOD'] == "POST") {
                                        $comment = filter_var($_POST['comment'] , FILTER_SANITIZE_STRING);
                                        $userId = $_SESSION['userid'];
                                        $itemId = $item['item_id'];

                                        // Validate 
                                        if (!empty($comment)) {
                                            // insert 
                                            $stmtComment = $conn->prepare("INSERT INTO comments
                                                                        (comment, created_at, user_id, item_id)
                                                                VALUES  (:xcomment , now() , :xuser , :xitem ) ");
                                            $stmtComment->execute(array(
                                                'xcomment' => $comment,
                                                'xuser' => $userId,
                                                'xitem' =>$itemId,
                                            ));
                                            if ($stmtComment) {
                                                // Successful Inserted Message
                                                echo '<div class="alert alert-success"> 
                                                        Comment Added
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>';
                                            } else {
                                                // Error Inserted Message - No Data Inserted Yet!
                                                $msg = "No Data Inserted Yet!";
                                                redirect2Home('info', $msg, 3, $_SERVER['HTTP_REFERER']);
                                            }
                                            
                                        }else {
                                            echo '<div class="alert alert-danger"> 
                                                    The comment field is required.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>';
                                        }
                                    }

                                        
                                    ?>
                                    <div class="add-comment w-50" id="add-comment">
                                        <form
                                            action="<?php echo $_SERVER['PHP_SELF'].'?id='. $item['item_id'].'#comment' ?>"
                                            method="post">
                                            <label>Add Your Review</label>
                                            <textarea class="form-control" name="comment" required></textarea>
                                            <input class="btn btn-danger btn-sm mt-2 " type="submit" value="Submit">
                                        </form>

                                    </div>
                                    <?php }else {
                                        echo '<a href="login.php">Login</a> or <a href="register.php">Register</a> to add your review.';
                                    
                                    } ?>



                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- description, comments row  -->
                            <div class="row">


                                <nav class="w-100">
                                    <div class="nav nav-tabs" id="product-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab"
                                            href="#product-desc" role="tab" aria-controls="product-desc"
                                            aria-selected="true">Description</a>
                                        <a class="nav-item nav-link" id="product-comments-tab" data-toggle="tab"
                                            href="#product-comments" role="tab" aria-controls="product-comments"
                                            aria-selected="false">Comments</a>
                                        <a class="nav-item nav-link" id="product-rating-tab" data-toggle="tab"
                                            href="#product-rating" role="tab" aria-controls="product-rating"
                                            aria-selected="false">Rating</a>
                                    </div>
                                </nav>
                                <div class="tab-content p-3 w-100" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="product-desc" role="tabpanel"
                                        aria-labelledby="product-desc-tab"> <?php echo $item['description'] ?></div>
                                    <div class="tab-pane fade" id="product-comments" role="tabpanel"
                                        aria-labelledby="product-comments-tab">
                                        <?php
                                            $comments = getComments('comments.item_id' , $item['item_id'] , 'AND comments.approval = 1');
                                            if (!empty($comments)) {
                                                echo "<ul class='product-comments'>";
                                                    foreach ($comments as $comment) {
                                                        $createdAt = date('D, d M Y' , strtotime($comment['created_at']));
                                                        ?>
                                                        <li class="item">
                                                            By <a href="#"><strong><?php echo $comment['username']; ?></strong></a>

                                                            on<small class='text-muted ml-2'><?php echo $createdAt; ?></small>
                                                            <p> <?php echo $comment['comment']; ?></p>

                                                        </li>
                                                        <?php
                                                    }
                                                echo "</ul>";
                                            }else {
                                                echo "<div class='alert alert-warning' role='alert'>No Comments Found</div>";
                                            }
                                           
                                        ?>
                                    </div>
                                    <div class="tab-pane fade" id="product-rating" role="tabpanel"
                                        aria-labelledby="product-rating-tab"> Cras ut ipsum ornare, aliquam ipsum non,
                                        posuere
                                        elit. In hac habitasse platea dictumst. Aenean elementum leo augue, id fermentum
                                        risus
                                        efficitur vel. Nulla iaculis malesuada scelerisque. Praesent vel ipsum felis. Ut
                                        molestie, purus aliquam placerat sollicitudin, mi ligula euismod neque, non
                                        bibendum
                                        nibh neque et erat. Etiam dignissim aliquam ligula, aliquet feugiat nibh rhoncus
                                        ut.
                                        Aliquam efficitur lacinia lacinia. Morbi ac molestie lectus, vitae hendrerit
                                        nisl.
                                        Nullam metus odio, malesuada in vehicula at, consectetur nec justo. Quisque
                                        suscipit
                                        odio velit, at accumsan urna vestibulum a. Proin dictum, urna ut varius
                                        consectetur,
                                        sapien justo porta lectus, at mollis nisi orci et nulla. Donec pellentesque
                                        tortor
                                        vel
                                        nisl commodo ullamcorper. Donec varius massa at semper posuere. Integer finibus
                                        orci
                                        vitae vehicula placerat. </div>
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.Default box -->

                <!-- similar-product box -->
                <div class="col-md-2">
                    <div class="card card-primary card-outline similar-products">
                        <div class="card-header text-center">
                            Similar Products
                        </div>
                        <div class="card-body">

                        </div>

                    </div>
                </div>
                <!-- /.similar-product box -->
            </div>
        </div>
        <!-- /.container -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
}
else {
  // Error:There Is No Such ID
  echo "<div class='container' style='width: 70%; margin-top: 50px;'>";
    redirect2Home('danger', 'Error: There Is No Such ID', 3 , 'index.php');
  echo "</div>";
}

include $tpl . 'footer.php';
?>