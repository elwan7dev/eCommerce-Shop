<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="dashboard.php">
        <img src="layout/images/bootstrap.svg" width="30" height="30" class="d-inline-block align-top" alt="logo">
        Brand
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="dashboard.php"><?php echo lang('HOME'); ?> <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><?php echo lang('CATEGORIES'); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><?php echo lang('ITEMS'); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><?php echo lang('MEMBERS'); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><?php echo lang('STATISTICS'); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><?php echo lang('LOGS'); ?></a>
            </li>
        </ul>
        <ul class="navbar-nav mr-px">
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
</nav>