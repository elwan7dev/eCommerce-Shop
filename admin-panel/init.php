<?php
// connnect to database 
include '../connectDB.php';


// Routes - more dynamic for maintanence
$tpl = 'includes/templates/'; //Templates Dir
$func= 'includes/functions/';
$css = 'layout/css/'; //css Dir
$js = 'layout/js/'; //js Dir
$langs ='includes/languages/'; //langs Dir

// include important files
include $func . 'func.php';
include $langs . 'en.php'; // langs files should include first
include $tpl . 'header.php';
// includes navbar.php on all pages expect the one with $noNavBar variable  
if (!isset($noNavBar)) {include $tpl . 'navbar.php';}