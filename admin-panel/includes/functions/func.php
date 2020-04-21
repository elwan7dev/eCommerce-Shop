<?php

function getTitle()
{
    global $pageTitle; // VIP: before this line func doesn't work

    if (isset($pageTitle)) {
        echo $pageTitle;
    } else {
        echo 'title';
    }
}

/**
 * Home Redirect function V2.0
 * [have params]
 * $alertType = bootstrap alert type
 * $msg= Echo the error msg
 * $seconds = seconds before redirecting
 * $url = url that redirect to it
 */
function redirect2Home($alertType, $msg, $seconds = 3, $url = 'dashboard.php')
{
    $link = '';
    if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' && $url == $_SERVER['HTTP_REFERER']) {
        $link = 'Prevoius ';

    } else {
        $pageName = str_replace('.php', '', $url);
        $link = $pageName;
    }
    echo "<div class='alert alert-$alertType' role='alert'>$msg</div>";
    echo "<div class='alert alert-info' text-center>You Will Redirect To <strong>$link</strong> Page In <strong>$seconds</strong> Seconds</div>";
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
 * @return
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
    } else {
        // not exist
        return false;
    }
}

/**
 * count # of items function v2.0
 * count number of items row in specific [table , condition] 
 * $item = colname 
 * $tblName = table name
 * $condition [optional] 
 * 
 * @return  fetchColumn Numbers
 */
function countItems($item, $tblName , $condition ='')
{
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT($item) FROM $tblName $condition");
    $stmt->execute();
    // nubers of col retreived
    return $stmt->fetchColumn();

}
