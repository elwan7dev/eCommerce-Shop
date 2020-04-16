<?php
// initialize php file
include 'init.php';
include $tpl . 'header.php';
include $langs . 'en.php'
?>
    <form class="login-form" action="" method="post" >
        <h4 class="text-center">Admin Login</h4>
        <input class="form-control" type="text" name="username" placeholder="username" autocomplete="off">
        <input class="form-control" type="text" name="password" placeholder="password" autocomplete="new-password">
        <input class="btn btn-primary btn-block" type="submit" value="login">
    </form>

<?php include $tpl . 'footer.php'?>
