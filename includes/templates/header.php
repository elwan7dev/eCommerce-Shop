<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="layout/images/store.png" >

    <!-- bootstrap -->
    <link rel="stylesheet" href="<?php echo $css ?>bootstrap.min.css">
    <!-- jQuery UI - v1.12.1  -->
    <link rel="stylesheet" href="<?php echo $css ?>jquery-ui.css">
    <!-- jQuery SelectBoxIt Plugins -->
    <link rel="stylesheet" href="<?php echo $css ?>jquery.selectBoxIt.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?php echo $css ?>icheck-bootstrap.min.css">
    <!-- font awesome -->
    <link rel="stylesheet" href="<?php echo $css ?>all.min.css">
    <link rel="stylesheet" href="<?php echo $css ?>fontawesome.min.css">
    <!-- custom styles -->
    <link rel="stylesheet" href="<?php echo $css ?>main.css">

    <title><?php getTitle(); ?></title>
</head>

<body>
    <div class="upper-bar">
        <div class="container">
            <?php 
                if (isset($_SESSION['username'])) {
                    echo "<span>Welcome <a href='logout.php'> ".
                        $_SESSION['username'] . 
                        "</a></span>"; 
                    echo '<a href="profile.php"> | Profile</a>';   
                }else {                          
            
            ?>
                <a href="login.php" >
                <span>Login</span> |
                </a> 
                <a href="register.php" >
                <span > Signup</span>
                </a> 

            <?php } ?>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
        <a class="navbar-brand" href="/eCommerce">
            <img src="layout/images/bootstrap.svg" width="30" height="30" class="d-inline-block align-top" alt="logo">
            Brand
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <?php 
                    foreach (getCats() as $cat) {
                        $pageName = str_replace(' ', '-' , $cat['name']);
                        echo "<li class='nav-item'>
                                    <a class='nav-link' href='categories.php?page=".$cat['cat_id']."&pagename=".$pageName ."'> ". $cat['name'] ."</a>
                              </li>";
                    }
                
                ?> 
            </ul>
            
        </div>
        </div>
    
    </nav>