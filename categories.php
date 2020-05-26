<?php
session_start();
$pageTitle = 'Categories';

// initialize php file
include 'init.php';
echo "Welcome in Categories page <br >";
echo "Page id = " .$_GET['page'];

include $tpl . 'footer.php'
?>