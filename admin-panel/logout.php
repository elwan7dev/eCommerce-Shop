<?php

// start the session
session_start(); 
// unset the datat
session_unset();

session_destroy();
header('location: index.php'); // redirect to  login page
exit();

