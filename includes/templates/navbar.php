<div class="upper-bar">
    <nav class="navbar navbar-expand-sm p-0">
        <div class="container">
            <?php 
                if (isset($_SESSION['username']) || isset($_SESSION['admin'])) { 
                    $profileName = isset($_SESSION['username']) ?  $_SESSION['username'] : $_SESSION['admin'] 
                    ?>
            <ul class="navbar-nav ml-auto">
                        <li class="nav-item" title="Profile">
                            <a href="profile.php" class="nav-link"><?php echo $profileName ?></a>
                        </li>
                        <li class="nav-item">
                            <a href="ads.php" target="_blank" class="nav-link">New-Ad</a>
                        </li>
                        <li class="nav-item">
                            <a href="logout.php" class="nav-link">Logout</a>
                        </li>
                    </ul>
            <?php
                }else {                          
            
                ?>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="login.php" class="nav-link"> Login</a>
                </li>
                <li class="nav-item">
                    <a href="register.php" class="nav-link">Signup</a>
                </li>
            </ul>
            <?php } ?>
        </div>
    </nav>
</div>

<!-- Main Top Bar -->
<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
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
                    // get ultimate get func
                    $cats = getAllRows('name , cat_id','categories', NULL , NULL , 'created_at' , 'ASC');
                    foreach ($cats as $cat) {
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