<?php
session_start();


if (isset($_SESSION['username'])) {
    $pageTitle = 'Dashboard';
    include 'init.php'; // initialize php file
    // Page Code here
    $latestMembers = getLatest('*' , 'users', 'user_id');
   
    ?>
    <!-- HTML Components -->
    <div class="main-content">

        <section class="home-stats text-center">
            <div class="container">
                <h1>Dashboard</h1>
                <div class="row">
                    <div class="col-md-3">
                        <div class="stat bg-info">
                            Total Members
                            <span>
                                <a href="members.php">
                                    <?php echo countItems('user_id' , 'users'); ?>
                                </a> 
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat bg-danger">
                            Pending Members
                            <span>
                                <a href="members.php?action=manage&page=pending">
                                    <?php echo countItems('reg_status' , 'users', 'WHERE reg_status = 0'); ?>

                                </a> 
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat bg-success">
                            Total Items
                            <span>300</span>
                        </div>
                    </div>
                    <div class="col-md-3 ">
                        <div class="stat bg-warning">
                            Total Comments
                            <span>300</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="latest">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-users"></i> Latest Registerd Users
                            </div>
                            <div class="card-body">
                                <?php
                                     foreach ($latestMembers as $row) {
                                         echo $row['username'] . "<br>";
                                     }
                                        
                                ?>
                            </div>
                            <div class="card-footer">
                                footer
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-tag"></i> Latest Items
                            </div>
                            <div class="card-body">
                                body
                            </div>
                            <div class="card-footer text-muted">
                                footer
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>







<?php



    
    // foooter temp
    include $tpl . 'footer.php';
} else {
    header('location: index.php');
    exit();
}
