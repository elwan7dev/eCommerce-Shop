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
     echo "<div class='alert alert-info' text-center>You Will Redirect In <strong>$seconds</strong> Seconds</div>";
    //  link to redirect url
     header("refresh:$seconds;url=$url");
     exit();
 }


/**
 * (Dynamic SELECT query)
 * isExist fuction v1.0
 * : check if an item exist in DB or not [have params] 
 * $colName = itemName =>the item to select [EX: user, item , category + Must be naming like DB]
 * $tblName = tableName => the table to select from     [EX: users, items , categories]
 * $value = the value of the selected-item 
 * 
 */

function isExist($colName, $tblName, $value)
{
    global $conn;
    $statement = $conn->prepare("SELECT $colName FROM $tblName WHERE $colName = ?");
    $statement->execute(array($value));

    
    if ($statement->rowCount()) {
        // value exist in DB
        return true;
    }else {
        // not exist
        return false;
    }

}
