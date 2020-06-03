<?php
/**
 * Template page
 */

session_start();

if (isset($_SESSION['admin'])) {
    $pageTitle = 'Comments'; //page title to check it for title tag
    include 'init.php'; // initialize php file
    // Page Code here

    // Code page here
    // split page with GET request
    $action = isset($_GET['action']) ? $_GET['action'] : 'manage';

    if ($action == 'manage') {
        // retreive all items from DB - with inerr join  
        $stmt = $conn->prepare("SELECT comments.* , items.name , users.username 
                                FROM comments
                                INNER JOIN items ON items.item_id = comments.item_id
                                INNER JOIN users ON users.user_id  = comments.user_id 
                                ORDER BY created_at DESC");
                                
        $stmt->execute();
        // fetch all data and asign in array
        $rows = $stmt->fetchAll();
        ?>
<!-- start html componants --> 
<h1 class="text-center">Manage Comments</h1>
<div class="container">
    <?php  if (! empty($rows)) { ?>
    <div class="table-responsive">
        <table class="table main-table table-bordered  text-center">
            <thead class="thead-light">
                <tr>
                    <th scope="col">#ID</th>
                    <th scope="col">Commnets</th>
                    <th scope="col">Item Name</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Controls</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // loop on $rows array and print dynamic data
                foreach ($rows as $row) {
                    // trick to change style of pending item row
                    $class = ($row['approval'] == 0) ? "class='table-secondary text-muted' title='Pending Item'" : '';

                    echo "<tr $class >"; 
                    echo "<th scope='row'>" . $row['comment_id'] . " </th>";
                    echo "<td>" . $row['comment'] . " </td>";
                    echo "<td>" . $row['name'] . " </td>";
                    echo "<td>" . $row['username'] . " </td>";
                    echo "<td>" . $row['created_at'] . " </td>";
                    echo "<td>
                                <a href='comments.php?action=delete&commentid=" . $row['comment_id'] . "' class='btn btn-danger btn-sm  confirm' title='Delete Comment'><i class='fas fa-trash-alt'></i></a>";
                                if ($row['approval'] == 1) {
                                    echo "<a href='comments.php?action=approve&commentid=" . $row['comment_id'] . "' class='btn btn-dark btn-sm activate confirm' title='Hide Comment'><i class='far fa-eye-slash'></i></a>";
                                } else {
                                    echo "<a href='comments.php?action=approve&commentid=" . $row['comment_id'] . "' class='btn btn-primary btn-sm activate confirm' title='Appear Comment'><i class='far fa-eye'></i></a>";
                                }
                    
                    echo "</td>";
                    echo "</tr>";
                }
                ?>

            </tbody>
        </table>
    </div>
        <?php
            }else {
                echo "<div class='alert alert-warning'> No Data Found</div>";
            }
        ?>
</div>

        <?php

    }elseif ($action == 'delete') {
        echo "<h1 class='text-center'>Delete Comment</h1>";
        echo "<div class='container' style='width: 70%;'>";
        // check if get request user id is numeric & get the integer value of it.
        $commentId = (isset($_GET['commentid']) && is_numeric($_GET['commentid'])) ? intval($_GET['commentid']) : false;

        // if there is such ID - delete it
        if ($commentId != false && isExist('comment_id', 'comments', $commentId)) {
            // prepare Query
            $stmt = $conn->prepare("DELETE FROM comments WHERE comment_id = :xid");
            // bind params
            $stmt->bindParam(':xid', $commentId);
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
    }elseif ($action == 'approve') {
        echo "<h1 class='text-center'>Approved Comment</h1>";
        echo "<div class='container' style='width: 70%;'>";
        // check if get request user id is numeric & get the integer value of it.
        $commentId = (isset($_GET['commentid']) && is_numeric($_GET['commentid'])) ? intval($_GET['commentid']) : false;

        // if there is such ID - Approved it
        if ($commentId != false && isExist('comment_id', 'comments', $commentId)) {
            // check if approved or not 
            $stmtCheck = $conn->prepare("SELECT approval FROM comments WHERE comment_id = ? LIMIT 1");
            $stmtCheck->execute(array($commentId));
            $row = $stmtCheck->fetch();
            if ($row['approval'] == 0) {
                $xappr = 1;
            }else {
                $xappr = 0;
            }

            // prepare Query
            $stmt = $conn->prepare("UPDATE comments SET approval = ? WHERE comment_id = ?");
            $stmt->execute(array($xappr , $commentId));
            $count = $stmt->rowCount();

            // Successful deleting Message
            if ($row['approval'] == 0) {
                $msg = "<strong>$count</strong> Comment Appear "; 
            }else {
                $msg = "<strong>$count</strong> Comment Hide ";   
            }
            redirect2Home('success', $msg, 1, $_SERVER['HTTP_REFERER']);

        } else {
            // Error deleting Message - There Is No Such ID!
            $msg = "There Is No Such ID!";
            redirect2Home('danger', $msg, 3);
        }
        echo "</div>";
    }
    else {
        header('location: index.php');
    }

    // ./ Code page

    // footer temp
    include $tpl . 'footer.php';
} else {
    header('location: index.php');
    exit();
}
