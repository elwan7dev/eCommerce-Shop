<?php
session_start();
$pageTitle = 'Profile';

// initialize php file
include 'init.php';

if (isset($_SESSION['username']) || isset($_SESSION['admin'])) {
    $profileName = isset($_SESSION['username']) ?  $_SESSION['username'] : $_SESSION['admin']; 

    // fetch user record from DB
    $userStmt = $conn->prepare("SELECT * FROM users WHERE username =? ");
    $userStmt->execute(array($profileName));
    $row =$userStmt->fetch();

    $userId = $row['user_id'];
    $createdAt = date('D, d M Y' , strtotime($row['created_at']));


    ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <!-- breadcrumb -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/eCommerce">Home</a></li>
                        <li class="breadcrumb-item active">User Profile</li>
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
            <div class="row info">
                <!-- col - usre info -->
                <div class="col-md-3 personal-data">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="layout/images/avatar.jpg"
                                    alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center"><?php echo $row['username']; ?></h3>

                            <p class="text-muted text-center"><?php echo $createdAt ?></p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Ads</b> <a class="float-right"><?php echo countItems('item_id', 'items', "WHERE member_id =$userId") ;?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Orders</b> <a class="float-right">322</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Comments</b> <a class="float-right"><?php echo countItems('comment_id', 'comments', "WHERE user_id =$userId") ;?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Friends</b> <a class="float-right">13,287</a>
                                </li>
                            </ul>

                            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About Me</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-user mr-1"></i> Full Name</strong>

                            <p class="text-muted">
                                <?php echo $row['full_name']; ?>
                            </p>

                            <hr>

                            <strong><i class="far fa-envelope mr-1"></i> Email</strong>

                            <p class="text-muted"><?php echo $row['email'] ?></p>

                            <hr>

                            <strong><i class="fas fa-tags mr-1"></i> Fav. Categories</strong>

                            <p class="text-muted">
                                <span class="tag tag-danger">UI Design</span>
                                <span class="tag tag-success">Coding</span>
                                <span class="tag tag-info">Javascript</span>
                                <span class="tag tag-warning">PHP</span>
                                <span class="tag tag-primary">Node.js</span>
                            </p>

                            <hr>

                            <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam
                                fermentum enim neque.</p>

                            <a href="profile.php#settings" class="btn btn-danger btn-block"><i class="fas fa-edit mr-2"></i><b>Edit</b></a>
                            
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->

                <div class="col-md-9 activity-data">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#ads" data-toggle="tab">Ads</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#comments" data-toggle="tab">Comments</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="ads">
                                    <?php 
                                        // retrieve all ads of signed user
                                        $items = getAllRows("*" , "items" , "WHERE member_id = $userId");
                                        // $items = getItems('member_id' , $row['user_id']);
                                        if (! empty($items)) {  
                                            echo '<div class="row">';
                                            foreach ($items as $item) { 
                                                                                            
                                            // img destination
                                            if (empty($item['image'])) {
                                                // default
                                                $itemImgSrc = "layout/images/image.jpg";
                                            }else{
                                                $itemImgSrc = "data/uploads/items/{$item['image']}";
                                            } 
                                            
                                            ?>
                                            <div class="col-sm-6 col-md-3">
                                                <div class="card item-box">
                                                    <?php
                                                        if ($item['approval'] == 0) {
                                                            echo '<span class="approval-status">Wating Approval</span>';
                                                        }

                                                    ?>
                                                    <span class="price-tag"><?php echo '$' . $item['price'];?></span>
                                                    <a href="product.php?id=<?php echo $item['item_id'] ?>">
                                                        <img src="<?php echo $itemImgSrc; ?>" class="card-img-top" alt="AD Image">
                                                    </a>
                                                    <div class="card-body">
                                                        <a href="product.php?id=<?php echo $item['item_id'] ?>" >
                                                            <h5 class="product-title"><?php echo $item['name']; ?> </h5>
                                                        </a>
                                                        <p class="product-description"><?php echo $item['description']; ?> </p>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                            }
                                            echo '</div>';
                                            // ./row
                                        }else {
                                            echo "<div class='alert alert-warning'> No Ads Found</div>";
                                            echo "<a href='ads.php' class='btn btn-primary btn-sm' target='_blank'><i class='fas fa-plus'></i> New Ad</a>";
                                        }
                                    ?>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="comments">
                                    <?php
                                    $comments = getComments('comments.user_id' , $userId);
                                    if (! empty($comments)) {
                                    
                                    ?>
                                    <!-- The timeline -->
                                    <div class="timeline timeline-inverse">
                                        <!-- timeline time label -->
                                        <div class="time-label">
                                            <span class="bg-danger">
                                                10 Feb. 2014
                                            </span>
                                        </div>
                                        <!-- /.timeline-label -->

                                        <!-- timeline item -->
                                        <?php
                                                
                                                foreach ($comments as $comment) { 
                                                    // trick to change style of pending item row
                                                    $class = ($comment['approval'] == 0) ? "bg-secondary" : '';
                                                    $title = ($comment['approval'] == 0) ? "title='Hidden Comment'" : '';
                                                    
                                                    ?>
                                                    <!-- timeline item -->
                                                    <div>
                                                        <div class="timeline-item <?php echo $class; ?>" <?php echo $title ?>>
                                                            <span class="time"><i class="far fa-clock"></i>
                                                                <?php echo time_Ago(strtotime($comment['created_at']) ); ?> </span>

                                                            <h3 class="timeline-header">Your Comment On 
                                                                <a href="product.php?id=<?php echo $comment['item_id'];?>"> 
                                                                    <?php echo $comment['item_name']; ?>
                                                                </a> 
                                                            </h3>

                                                            <div class="timeline-body">
                                                                <?php echo $comment['comment'] ?>
                                                            </div>
                                                            <div class="timeline-footer">
                                                                <a href="#" class="btn btn-primary btn-sm">View comment</a>
                                                                <a href="#" class="btn btn-danger btn-sm">Delete</a>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- END timeline item -->
                                                <?php }  ?>
                                        <!-- timeline time label -->
                                        <div class="time-label">
                                            <span class="bg-success">
                                                3 Jan. 2014
                                            </span>
                                        </div>
                                        <!-- /.timeline-label -->
                                        <!-- timeline item -->
                                        <div>
                                            <i class="fas fa-camera bg-purple"></i>

                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                                                <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos
                                                </h3>

                                                <div class="timeline-body">
                                                    <img src="http://placehold.it/150x100" alt="...">
                                                    <img src="http://placehold.it/150x100" alt="...">
                                                    <img src="http://placehold.it/150x100" alt="...">
                                                    <img src="http://placehold.it/150x100" alt="...">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END timeline item -->
                                        <div>
                                            <i class="far fa-clock bg-gray"></i>
                                        </div>
                                    </div>

                                    <?php 
                                        }else {
                                            echo "<div class='alert alert-warning'> No Comments Found</div>";
                                        }
                                    ?>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="timeline">
                                    <!-- The timeline -->
                                    <div class="timeline timeline-inverse">
                                        <!-- timeline time label -->
                                        <div class="time-label">
                                            <span class="bg-danger">
                                                10 Feb. 2014
                                            </span>
                                        </div>
                                        <!-- /.timeline-label -->
                                        <!-- timeline item -->
                                        <div>
                                            <i class="fas fa-envelope bg-primary"></i>

                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> 12:05</span>

                                                <h3 class="timeline-header"><a href="#">Support Team</a> sent you an
                                                    email</h3>

                                                <div class="timeline-body">
                                                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                                    weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                                    jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                                    quora plaxo ideeli hulu weebly balihoo...
                                                </div>
                                                <div class="timeline-footer">
                                                    <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END timeline item -->
                                        <!-- timeline item -->
                                        <div>
                                            <i class="fas fa-user bg-info"></i>

                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                                                <h3 class="timeline-header border-0"><a href="#">Sarah Young</a>
                                                    accepted your friend request
                                                </h3>
                                            </div>
                                        </div>
                                        <!-- END timeline item -->
                                        <!-- timeline item -->
                                        <div>
                                            <i class="fas fa-comments bg-warning"></i>

                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                                                <h3 class="timeline-header"><a href="#">Jay White</a> commented on your
                                                    post</h3>

                                                <div class="timeline-body">
                                                    Take me to your leader!
                                                    Switzerland is small and neutral!
                                                    We are more like Germany, ambitious and misunderstood!
                                                </div>
                                                <div class="timeline-footer">
                                                    <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END timeline item -->
                                        <!-- timeline time label -->
                                        <div class="time-label">
                                            <span class="bg-success">
                                                3 Jan. 2014
                                            </span>
                                        </div>
                                        <!-- /.timeline-label -->
                                        <!-- timeline item -->
                                        <div>
                                            <i class="fas fa-camera bg-purple"></i>

                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                                                <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos
                                                </h3>

                                                <div class="timeline-body">
                                                    <img src="http://placehold.it/150x100" alt="...">
                                                    <img src="http://placehold.it/150x100" alt="...">
                                                    <img src="http://placehold.it/150x100" alt="...">
                                                    <img src="http://placehold.it/150x100" alt="...">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END timeline item -->
                                        <div>
                                            <i class="far fa-clock bg-gray"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="settings">
                                    <form class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="inputName"
                                                    placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="inputEmail"
                                                    placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputName2"
                                                    placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputExperience"
                                                class="col-sm-2 col-form-label">Experience</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="inputExperience"
                                                    placeholder="Experience"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputSkills"
                                                    placeholder="Skills">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox"> I agree to the <a href="#">terms and
                                                            conditions</a>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
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