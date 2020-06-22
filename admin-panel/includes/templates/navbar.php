<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
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
            <li class="nav-item">
                <a class="nav-link" href="#"><?php echo lang('STATISTICS'); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><?php echo lang('LOGS'); ?></a>
            </li>
        </ul>
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <?php echo $_SESSION['admin']; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="members.php?action=edit&userid=<?php echo $_SESSION['adminid'];?>"><?php echo lang('PROFILE'); ?></a>
                    <a class="dropdown-item" href="#"><?php echo lang('SETTING'); ?></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php"><?php echo lang('LOGOUT'); ?></a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/eCommerce" target="_blank">Visit Shop</a>
            </li>
        </ul>
    </div>
    </div>
   
</nav>