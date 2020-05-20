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
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
        <a class="navbar-brand" href="dashboard.php">
            <img src="layout/images/bootstrap.svg" width="30" height="30" class="d-inline-block align-top" alt="logo">
            Brand
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php"><?php echo lang('HOME'); ?> <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="categories.php"><?php echo lang('CATEGORIES'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="items.php"><?php echo lang('ITEMS'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="members.php"><?php echo lang('MEMBERS'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="comments.php"><?php echo lang('COMMENTS'); ?></a>
                </li>
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <?php echo $_SESSION['username']; ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="members.php?action=edit&userid=<?php echo $_SESSION['userid'];?>"><?php echo lang('PROFILE'); ?></a>
                        <a class="dropdown-item" href="#"><?php echo lang('SETTING'); ?></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php"><?php echo lang('LOGOUT'); ?></a>
                    </div>
                </li>
            </ul>
        </div>
        </div>
    
    </nav>