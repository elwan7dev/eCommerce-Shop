<?php
session_start();


if (isset($_SESSION['username'])) {
    $pageTitle = 'Dashboard';
    include 'init.php'; // initialize php file
    // Page Code here

    // get the latest registered members and assign in array 
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
                        <a href="members.php">
                            <span>
                                <?php echo countItems('user_id' , 'users'); ?>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat bg-danger">
                        Pending Members
                        <a href="members.php?action=manage&page=pending">
                            <span>
                                <?php echo countItems('reg_status' , 'users', 'WHERE reg_status = 0'); ?>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat bg-success">
                        Total Items
                        <a href="items.php">
                            <span>
                                <?php echo countItems('item_id' , 'items') ?>
                            </span>
                        </a>
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
                    <!-- TABLE: LATEST USERS -->
                    <div class="card" id="my-card">
                        <div class="card-header border-transparent">
                            <i class="fas fa-users"></i> Latest Members
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>User ID</th>
                                            <th>Username</th>
                                            <th>Registered Date</th>
                                            <th>Controls</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // loop on $rows array and print dynamic data
                                        foreach ($latestMembers as $row) {
                                            // trick to change style of pending user row
                                            $class = ($row['reg_status'] == 0) ? "class='text-muted'" : '';
                                            echo "<tr $class>"; 
                                            echo "<th scope='row'>"; 
                                                echo "<a href='members.php?action=edit&userid=" . $row['user_id'] . "'>" . $row['user_id'] . " </a>";
                                            echo "</th>";
                                            echo "<td>" . $row['username'] . " </td>";
                                            echo "<td>" . $row['date'] . " </td>";
                                            echo "<td>
                                                <a href='members.php?action=edit&userid=" . $row['user_id'] . "' class='btn btn-success btn-sm' title='Edit Member'><i class='fas fa-edit'></i></a>
                                                <a href='members.php?action=delete&userid=" . $row['user_id'] . "' class='btn btn-danger btn-sm confirm' title='Delete Member'><i class='fas fa-trash-alt'></i></a>";
                                                if ($row['reg_status'] == 0) {
                                                    echo "<a href='members.php?action=activate&userid=" . $row['user_id'] . "' class='btn btn-primary btn-sm activate confirm' title='Activate Member'><i class='fas fa-check'></i></a>";
                                                }
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <a href="members.php?action=add" class="btn btn-sm btn-info float-left">Add New Member</a>
                            <a href="members.php" class="btn btn-sm btn-secondary float-right">View All Members</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-sm-6">
                    <!--  LATEST ITEMS -->
                    <div class="card" id="my-card">
                        <div class="card-header border-transparent">
                            <i class="fas fa-tag"></i> Recently Added Products

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            body
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer text-center">
                            <a href="#" class="uppercase">View All Products</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
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