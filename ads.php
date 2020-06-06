<?php
session_start();
$pageTitle = 'Ads';

// initialize php file
include 'init.php';

if (isset($_SESSION['username']) || isset($_SESSION['admin'])) {

    // check if the user coming from post request
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
       // get the vars from the form
       $name = filter_var($_POST['name'] , FILTER_SANITIZE_STRING); 
       $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);  
       $desc = filter_var($_POST['desc'] , FILTER_SANITIZE_STRING);
       $country = filter_var($_POST['country'] , FILTER_SANITIZE_STRING);
       $status = filter_var($_POST['status'] , FILTER_SANITIZE_STRING);
       $categoryID = filter_var($_POST['category'] , FILTER_SANITIZE_STRING);
        
       // validate Form in server side
       // declare empty errors array
       $formErrors  = array();
        if (empty($name)) {
            $formErrors[] = "name-empty";
        }else if (strlen($name) > 1 && strlen($name) < 4) {
                $formErrors[] = "name-less";
        }
        if (empty($price)) {
            $formErrors[] = "price-empty";
        }
        if (empty($desc)) {
            $formErrors[] = "desc-empty";
        }
        if (empty($country)) {
            $formErrors[] = "country-empty";
        }
        if (empty($status)) {
            $formErrors[] = "status-empty";
        }
        if (empty($categoryID)) {
            $formErrors[] = "cat-empty";
        }

        // check if there is no errors - insert in DB
        if (empty($formErrors)) {
            // Insert user data into the DB
            // registeration_status = 1 by default bacause the admin adding this users - so, approved
            $stmtItem = $conn->prepare("INSERT INTO items
                                (name, price, description, country_made, status , cat_id, member_id, created_at)
                                VALUES (:xname, :xprice, :xdesc, :xcountry , :xstatus, :xcat, :xmember , now())");
            $stmtItem->execute(array(
                'xname' => $name,
                'xprice' => $price,
                'xdesc' => $desc,
                'xcountry' => $country,
                'xstatus' => $status,
                'xcat' => $categoryID,
                'xmember' => $_SESSION['userid'],
            ));

            $count = $stmtItem->rowCount();
            if ($count > 0) {
                // Successful Inserted Message
                $msg = "<strong>$count</strong> Record Have Been Inserted";
                redirect2Home('success', $msg, 3, 'profile.php');
            } else {
                // Error Inserted Message - No Data Inserted Yet!
                $msg = "No Data Inserted Yet!";
                redirect2Home('info', $msg, 3, $_SERVER['HTTP_REFERER']);
            }
            
        }

    }

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
                                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                        <!-- start Name & Price , Image in same row field -->
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="name">Name</label>
                                                <input type="text" name="name" class="form-control live 
                                                    <?php 
                                                        if(in_array('name-empty' , $formErrors) ||
                                                            in_array('name-less' , $formErrors)){echo 'is-invalid'; }?>" 
                                                    data-class=".live-name" placeholder="Item's Name" required pattern=".{8,}"
                                                    title="The Name Field Must be 8 chracters at least.">
                                                <!-- Print form-errors -->
                                                <?php
                                                    if(!empty($formErrors)){
                                                        if(in_array('name-empty' , $formErrors)){
                                                            echo "<span class='invalid-feedback' role='alert'>
                                                                    <strong>The Name field is required.</strong>
                                                                </span>";
                                                        }
                                                        if(in_array('name-less' , $formErrors)){
                                                            echo "<span class='invalid-feedback' role='alert'>
                                                                    <strong>The Name must be at least 4 characters.
                                                                    </strong>
                                                                </span>";
                                                        }
                                                        
                                                    }
                                                ?>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="price">Price</label>
                                                <input type="number" name="price" class="form-control live
                                                    <?php 
                                                        if(in_array('price-empty' , $formErrors)){echo 'is-invalid'; }?>"
                                                    data-class=".live-price" placeholder="Item's Price" required>
                                                <!-- Print form-errors -->
                                                <?php
                                                    if(!empty($formErrors)){
                                                        if(in_array('price-empty' , $formErrors)){
                                                            echo "<span class='invalid-feedback' role='alert'>
                                                                    <strong>The Price field is required.</strong>
                                                                </span>";
                                                        }
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <!-- start Description field -->
                                        <div class="form-group">
                                            <label for="desc">Description</label>
                                            <textarea name="desc" class="form-control live
                                                <?php 
                                                    if(in_array('desc-empty' , $formErrors)){echo 'is-invalid'; }?>" 
                                                data-class=".live-desc" placeholder="Item's Description" required
                                                pattern=".{20,}" title="The Description Field must be 20 characters at least."></textarea>
                                            <!-- Print form-errors -->
                                            <?php
                                                if(!empty($formErrors)){
                                                    if(in_array('desc-empty' , $formErrors)){
                                                        echo "<span class='invalid-feedback' role='alert'>
                                                                <strong>The Description field is required.</strong>
                                                            </span>";
                                                    }
                                                }
                                            ?>
                                        </div>
                                        <!-- start Full Name field -->
                                        <div class="form-row">
                                            <div class="form-group col-md-8">
                                                <label for="country">Country Made</label>
                                                <input type="text" name="country" class="form-control 
                                                    <?php 
                                                        if(in_array('country-empty' , $formErrors)){echo 'is-invalid'; }?>"
                                                    placeholder="Country Made In" required>
                                                <!-- Print form-errors -->
                                                <?php
                                                    if(!empty($formErrors)){
                                                        if(in_array('country-empty' , $formErrors)){
                                                            echo "<span class='invalid-feedback' role='alert'>
                                                                    <strong>The Country field is required.</strong>
                                                                </span>";
                                                        }
                                                    }
                                                ?>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="status">Status</label>
                                                <select id="status" name="status" class="form-control 
                                                    <?php 
                                                        if(in_array('status-empty' , $formErrors)){echo 'is-invalid'; }?>" required>
                                                    <option value="" selected>Choose...</option>
                                                    <option value="1">new</option>
                                                    <option value="2">old</option>
                                                    <option value="3">like new</option>
                                                </select>
                                                <!-- Print form-errors -->
                                                <?php
                                                    if(!empty($formErrors)){
                                                        if(in_array('status-empty' , $formErrors)){
                                                            echo "<span class='invalid-feedback' role='alert'>
                                                                    <strong>The Status field is required.</strong>
                                                                </span>";
                                                        }
                                                    }
                                                ?>
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
                                                <select id="category" name="category" class="form-control 
                                                    <?php 
                                                        if(in_array('cat-empty' , $formErrors)){echo 'is-invalid'; }?>" required>
                                                    <option value="" selected>Choose...</option>
                                                    <?php
                                                        $cats = getAllRows('cat_id , name' , 'categories');
                                                        foreach ($cats as $cat) {
                                                            echo "<option value='". $cat['cat_id']."' >" .$cat['name'] . "</option>";
                                                        }
                                                    ?>
                                                </select>
                                                <!-- Print form-errors -->
                                                <?php
                                                    if(!empty($formErrors)){
                                                        if(in_array('cat-empty' , $formErrors)){
                                                            echo "<span class='invalid-feedback' role='alert'>
                                                                    <strong>The Category field is required.</strong>
                                                                </span>";
                                                        }
                                                    }
                                                ?>
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