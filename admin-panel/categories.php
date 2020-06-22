<?php
/**
 * Categories page
 * [add (insert)  -   edit (update)   -  delete ]
 */

session_start();

if (isset($_SESSION['admin'])) {
    $pageTitle = 'Categories'; //page title to check it for title tag
    include 'init.php'; // initialize php file
    // Page Code here

    // Code page here
    // split page with GET request
    $action = isset($_GET['action']) ? $_GET['action'] : 'manage';

    if ($action == 'manage') {  //***************start cats-manage page */

        // <!-- Dynamic order options  -->
        // $sort = 'ASC'; //INIT VALUE 
        $sortArr = array('ASC' , 'DESC');
        // CHECK IF SORT REQ IN ARRAY OPT  - default DESC
        $sort = (isset($_GET['sort']) && in_array($_GET['sort'], $sortArr)) ? $_GET['sort'] : 'DESC';
        
        // more dynamic order var - default created_at
        $orderArr = array('ordering' , 'created_at');
        $colName = (isset($_GET['orderby']) && in_array($_GET['orderby'], $orderArr)) ? $_GET['orderby'] : 'created_at';
        
        // retreive only parent categories from DB  order by $colName 
        $cats = getRows("*" , "categories" , "WHERE parent_id = 0" , NULL , $colName , $sort);  ?>

<!-- start html componants -->
<h1 class="text-center">Manage Categories</h1>
<div class="container categories">
    <?php  if (count($cats) > 0) { ?>
    <!--  CATEGORIES -->
    <div class="card">
        <div class="card-header border-transparent">
            <i class="fas fa-tag"></i> Categories
            <div class="options float-right">
                <!-- Dynamic order options  -->
                <i class="fas fa-sort"></i> Date: [
                    <a class="<?php if($sort == 'ASC' && $colName == 'created_at' ) {echo 'active';} ?>"
                        href="?sort=ASC&orderby=created_at">ASC</a> |
                    <a class="<?php if($sort == 'DESC' && $colName == 'created_at') {echo 'active';} ?>"
                        href="?sort=DESC&orderby=created_at">DESC</a>] &nbsp; &nbsp;
                <i class="fas fa-sort"></i> Ordering: [
                    <a class="<?php if($sort == 'ASC' && $colName == 'ordering') {echo 'active';} ?>"
                        href="?sort=ASC&orderby=ordering">ASC</a> |
                    <a class="<?php if($sort == 'DESC' && $colName == 'ordering') {echo 'active';} ?>"
                        href="?sort=DESC&orderby=ordering">DESC</a>] &nbsp; &nbsp;
               
                    <!-- Accessed by jQuery -->
                <i class="far fa-eye"></i> View: [   
                <span class="active" data-view="full" >Full</span> |
                <span data-view="classic">Classic</span>]

            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
            <?php
                foreach ($cats as $cat) {
                    echo "<div class='cat'>";
                        echo "<div class='hidden-buttons'>";
                            echo "<a href='categories.php?action=edit&catid=" . $cat['cat_id'] . "' class='btn btn-success btn-sm' title='Edit Category'><i class='fas fa-edit'></i></a>";
                            echo "<a href='categories.php?action=delete&catid=" . $cat['cat_id'] . "' class='btn btn-danger btn-sm confirm' title='Delete Category'><i class='fas fa-trash-alt'></i></a>";
                        echo "</div>";
                        echo "<h3>" . $cat['name'] . "</h3>";
                        echo "<div class='full-view'>";
                            if($cat['visibility'] == 0 || $cat['allow_comments'] == 0 || $cat['allow_ads'] == 0)
                            {
                                echo "<div class='tags'>";
                                    if($cat['visibility'] == 0){ echo "<span class='badge badge-pill badge-danger' title='Not Visible'><i class='far fa-eye-slash'></i></span>";}
                                    if($cat['allow_comments'] == 0){ echo "<span class='badge badge-pill badge-primary' title='Comments Disabled'><i class='fas fa-comment-slash'></i></span>";}
                                    if($cat['allow_ads'] == 0){ echo "<span class='badge badge-pill badge-warning' title='Ads Disabled'><i class='fas fa-ad'></i></span>";}
                                echo "</div>";
                            }
                            if($cat['description'] != ''){ echo "<p>". $cat['description'] ."</p>"; }
                        echo "</div>";
                        // /.full-view dev

                        // get child cats that have parent_id of current category
                        $childs = getRows("*", "categories", "WHERE parent_id = {$cat['cat_id']}", NULL, $colName, $sort);
                        if (!empty($childs)) {
                            echo '<div class="cat-childs">';
                                echo "<span>Sub-Categories</span>";
                                echo "<ul class='list-unstyled'>";
                                    foreach ($childs as $child) {
                                        echo "<li class='child-link'>
                                                <a href='categories.php?action=edit&catid=" . $child['cat_id'] . "'>{$child['name']}</a>
                                                <a href='categories.php?action=delete&catid=" . $child['cat_id'] . "' class='show-delete confirm' title='Delete Sub-Cat'>Delete</a>
                                            </li>";
                                    }
                                echo "</ul>";
                            echo '</div>';
                        }
                    echo "</div>";
                    // /.cat div
                    echo "<hr>";
                }
            ?>
        </div>
        <!-- /.card-body -->
        <div class="card-footer text-center">
            <a href='?action=add' class="btn btn-primary"><i class="fas fa-plus"></i> New Category</a>
        </div>
        <!-- /.card-footer -->
    </div>
    <!-- /.card -->
        <?php
            }else {
                echo "<div class='alert alert-warning'> No Data Found</div>";
                echo "<a href='?action=add' class='btn btn-primary'><i class='fas fa-plus'></i> New Category</a>";
            }
        ?>
</div>
<?php
    /***************End cat-manage page */

    }elseif ($action == 'add') { // ****** start cats-add page
        ?>

<!-- start html componants -->
<h1 class="text-center">Add New Category</h1>
<div class="container" style="width: 70%;">
    <form action="?action=insert" method="POST">
        <!-- start Name & Order in same row field -->
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" required="required" placeholder="Category Name">
            </div>
            <div class="form-group col-md-4">
                <label for="parent">Parent</label>
                <select id="parent" name="parent" class="form-control " required>
                    <option value="0" selected>None</option>
                    <?php
                        $cats = getRows("cat_id , name", "categories" , "WHERE parent_id = 0");
                        foreach ($cats as $cat) {
                            echo "<option value='". $cat['cat_id']."' >" .$cat['name'] . "</option>";
                        }
                    ?>
                </select>
              
            </div>
            <div class="form-group col-md-4">
                <label for="order">Order</label>
                <input type="number" name="order" class="form-control" placeholder="Arrange Categories by ordering">
            </div>
        </div>
        <!-- start description field -->
        <div class="form-group">
            <label for="desc">Description</label>
            <textarea type="test" name="desc" class="form-control"
             placeholder="Category Description"></textarea>
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
            $order = 0;

            // get the vars from the form
            $name = $_POST['name'];
            $parentId = $_POST['parent'];
            $order = intval($_POST['order']);  
            //finaly solved an hard fatal error
            /** solved using intval()
             * Fatal error: Uncaught PDOException: SQLSTATE[HY000]: 
             * General error: 1366 Incorrect integer value: '' for column 'ordering' 
             * 
             * bacause i'mtrying to insert an empty string into a column that
             *  is expecting an integer
             */
            $desc = $_POST['desc'];
            $visible = $_POST['visible'];
            $comments = $_POST['comments'];
            $ads = $_POST['ads'];

            
            // if there is errors - print alert errors in update page
            if (empty($name)) {
                echo "<div class='alert alert-danger' role='alert'>Name Field Can't Be <strong>Empty!</strong></div>";
            }
            // check if there is no errors - insert in DB
            if (!empty($name)) {
                // check if the category name that coming from Form exist in DB or Not
                // like this " SELECT name FROM categories WHERE name = $name"
                if (!isExist('name', 'categories', $name)) {

                    // Insert user data into the DB
                    // registeration_status = 1 by default bacause the admin adding this users - so, approved
                    $stmt = $conn->prepare("INSERT INTO categories
                            (name, parent_id, ordering, description, visibility ,allow_comments , allow_ads, created_at)
                            VALUES (:xname, :xparent, :xorder, :xdesc, :xvisible , :xcomm , :xads , now())");
                    $stmt->execute(array(
                        'xname' => $name,
                        'xparent' => $parentId,
                        'xorder' => $order,
                        'xdesc' => $desc,
                        'xvisible' => $visible,
                        'xcomm' => $comments,
                        'xads' => $ads
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

    }elseif ($action == 'edit') { /**************Start cats-edit page */

        // check if get request catid is numeric & get the integer value of it.
        $catID = (isset($_GET['catid']) && is_numeric($_GET['catid'])) ? intval($_GET['catid']) : 0;

        // Select all fields from record depend on this id
        $stmt = $conn->prepare("SELECT * FROM categories WHERE cat_id=? LIMIT 1");
        //execute Query
        $stmt->execute(array($catID)); //if cat_id are equal- select
        $row = $stmt->fetch(); //fetch row data from DB

        // if there is such ID - show the form
        if ($stmt->rowCount() > 0) {   ?>


<!-- start html componants -->
<h1 class="text-center">Edit Category</h1>
<div class="container" style="width: 70%;">
    <form action="?action=update" method="POST">
        <!-- add catid input here to post it in form add  to get it in update page   -->
        <input type="hidden" name="catid" value="<?php echo $catID; ?>">

        <!-- start Name & Order in same row field -->
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" required="required"
                    value="<?php echo $row['name']; ?>">
            </div>
            <div class="form-group col-md-4">
                <label for="parent">Parent</label>
                <select id="parent" name="parent" class="form-control" required>
                    <option value="0" <?php if($row['parent_id'] == 0) echo "selected"; ?>>None</option>
                    <?php
                        // get parents only
                        $cats = getRows("cat_id , name", "categories" , "WHERE parent_id = 0");
                        foreach ($cats as $cat) { ?>
                            <!-- if current cat_id = parent_id of edit cat => then is his parent -->
                            <option 
                                value="<?php echo $cat['cat_id']?>"
                                <?php if($row['parent_id'] == $cat['cat_id']) echo "selected"; ?>> <?php echo $cat['name']; ?>
                            </option>


                            <?php
                        }
                    ?>
                </select>
              
            </div>
            <div class="form-group col-md-4">
                <label for="Order">Order</label>
                <input type="number" name="order" class="form-control" value="<?php echo $row['ordering']; ?>">
            </div>
        </div>
        <!-- start description field -->
        <div class="form-group">
            <label for="desc">Description</label>
            <textarea  name="desc" class="form-control" required><?php echo $row['description']; ?></textarea>
        </div>
        <!-- start radio fields button -->
        <div class="form-row">
            <div class="form-group col-md-4">
                <label class="col-form-label">Visibility</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="visible" id="vis-yes" value="1"
                        <?php if ($row['visibility'] == 1){echo 'checked';}?>>
                    <label class="form-check-label" for="vis-yes">Yes</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="visible" id="vis-no" value="0"
                        <?php if ($row['visibility'] == 0){echo 'checked';}  ?>>
                    <label class="form-check-label" for="vis-no">No</label>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label class="col-form-label">Comments</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="comments" id="com-yes" value="1"
                        <?php if ($row['allow_comments'] == 1){echo 'checked';} ?>>
                    <label class="form-check-label" for="com-yes">Yes</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="comments" id="com-no" value="0"
                        <?php if ($row['allow_comments'] == 0){echo 'checked';} ?>>
                    <label class="form-check-label" for="com-no">No</label>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label class="col-form-label">Ads</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ads" id="ads-yes" value="1"
                        <?php if ($row['allow_ads'] == 1){echo 'checked';} ?>>
                    <label class="form-check-label" for="ads-yes">Yes</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ads" id="ads-no" value="0"
                        <?php if ($row['allow_ads'] == 0){echo 'checked';} ?>>
                    <label class="form-check-label" for="ads-no">No</label>
                </div>
            </div>

        </div>
        <!-- start button field -->
        <input type="submit" value="Save" class="btn btn-primary">
    </form>
</div>

<?php
        } else {
            // Error:There Is No Such ID
            echo "<div class='container' style='width: 70%; margin-top: 50px;'>";
            redirect2Home('danger', 'Error: There Is No Such ID', 3);
            echo "</div>";
        } /*****************End cat-edit page */

    }elseif ($action == 'update') { /***************Start cats-update page */
        echo "<h1 class='text-center'>Update Category</h1>";
        echo "<div class='container' style='width: 70%;'>";

        // check if user coming from http POST request to prevent browseing page directly
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            // get the vars from the form
            $catID = $_POST['catid'];
            $name = $_POST['name'];
            $parentId = $_POST['parent'];
            $order = intval($_POST['order']); 
            //finaly solved an hard fatal error
            /** solved using intval()
             * Fatal error: Uncaught PDOException: SQLSTATE[HY000]: 
             * General error: 1366 Incorrect integer value: '' for column 'ordering' 
             * 
             * bacause i'mtrying to insert an empty string into a column that is expecting an integer
             */
            
            $desc = $_POST['desc'];
            $visible = $_POST['visible'];
            $comments = $_POST['comments'];
            $ads = $_POST['ads'];
            

            // validate Form in server side
            // declare empty errors array
            $formErrors = array();
            if (empty($name)) {
                $formErrors[] = "name Field Can't Be <strong>Empty!</strong>";
            }
            if (strlen($name) < 4) {
                $formErrors[] = "name Can't Be Less Than <strong> 4 Character</strong>";
            }
           
            // if there is errors - print alert errors in update page
            if (!empty($formErrors)) {
                foreach ($formErrors as $error) {
                    echo "<div class='alert alert-danger' role='alert'>" . $error . "</div>";
                }
            }

            // if there is no errors - update in DB
            if (empty($formErrors)) {

                // Update the DB record with this info
                $stmt = $conn->prepare("UPDATE categories 
                        SET name = ?, parent_id = ?,  ordering = ?, description = ?, visibility = ?, allow_comments =? , allow_ads =?
                        WHERE cat_id =?");
                //if i used $_SESSION['userid'] instead if $_GET['userid'] = $userId
                //fatal error update in current user only
                $stmt->execute(array($name, $parentId, $order, $desc, $visible, $comments, $ads, $catID ));
                $count = $stmt->rowCount();

                if ($count > 0) {
                    // Successful updating Message
                    $msg = "<strong>$count</strong> Record Have Been Updated";
                    redirect2Home('success', $msg, 3, 'categories.php');
                } else {
                    // Error Updating Message - No Data Updated Yet!
                    $msg = "No Data Updated Yet!";
                    redirect2Home('info', $msg, 3, $_SERVER['HTTP_REFERER']);
                }

            }

        } else {
            // Error POST Request: You Can't Browse This Page Directly
            $msg = "Error: You Can't Browse This Page Directly";
            redirect2Home('danger', $msg, 6);

        }
        echo "</div>"; //end of container div

    }elseif ($action == 'delete') {
        echo "<h1 class='text-center'>Delete Member</h1>";
        echo "<div class='container' style='width: 70%;'>";
        // check if get request user id is numeric & get the integer value of it.
        $catID = (isset($_GET['catid']) && is_numeric($_GET['catid'])) ? intval($_GET['catid']) : false;

        // if there is such ID - delete it
        if ($catID != false && isExist('cat_id', 'categories', $catID)) {
            // prepare Query
            $stmt = $conn->prepare("DELETE FROM categories WHERE cat_id = :xid");
            // bind params
            $stmt->bindParam(':xid', $catID);
            $stmt->execute();
            $count = $stmt->rowCount();

            // Successful deleting Message
            $msg = "<strong>$count</strong> Record Have Been Deleted";
            redirect2Home('success', $msg, 3, $_SERVER['HTTP_REFERER']);

        } else {
            // Error deleting Message - There Is No Such ID!
            $msg = "There Is No Such ID!";
            redirect2Home('danger', $msg, 3);
        }
        echo "</div>";
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