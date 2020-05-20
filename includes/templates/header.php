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
    <!-- font awesome -->
    <link rel="stylesheet" href="<?php echo $css ?>all.min.css">
    <link rel="stylesheet" href="<?php echo $css ?>fontawesome.min.css">
    <!-- custom styles -->
    <link rel="stylesheet" href="<?php echo $css ?>main.css">

    <title><?php getTitle(); ?></title>
</head>

<body>
    <div class="upper">
        upper
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
                        echo "<li class='nav-item'>
                                    <a class='nav-link' href='categories.php?page=".$cat['cat_id'] ." '> " . $cat['name'] ."</a>
                              </li>";
                    }
                
                ?> 
            </ul>
            
        </div>
        </div>
    
    </nav>