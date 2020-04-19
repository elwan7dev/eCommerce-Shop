<?php

function getTitle()
{
    global $pageTitle; // VIP: before this line func doesn't work

    if (isset($pageTitle)) {
        echo $pageTitle;
    }else {
        echo 'title';
    }
}


/**
 * Home Redirect success function [this func accept params]
 * 
 * $alertType = bootstrap alert type
 * $errorMsg = Echo the error msg
 * $seconds = seconds before redirecting 
 * $url = url that redirect to it 
 */
 function redirect2Home($alertType, $errorMsg , $seconds = 3, $url='dashboard.php')
 {
     echo "<div class='alert alert-$alertType' role='alert'>$errorMsg</div>";
     echo "<div class='alert alert-info' text-center>You Will Redirect To Home In <strong>$seconds</strong> Seconds</div>";
    //  link to redirect url
     header("refresh:$seconds;url=$url");
     exit();
 }