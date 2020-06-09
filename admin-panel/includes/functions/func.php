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
 * getRows() fucntion v2.2
 * get rows of selected colname 
 * @param select $select = col to selected 
 * @param tblName $tblName = table [EX: users , items , categories]
 * @param where conditon 
 * @param and  AND in query
 * @param orderFeild 
 * @param ordering
 * @param limit
 * @return rows 
 */
function getRows($select, $tblName , $where = NULL , $and = NULL, $orderFeild = 'created_at' , $ordering = 'DESC' , $limit = NULL) 
{
    global $conn;
    $rowStmt = $conn->prepare("SELECT $select FROM $tblName $where $and ORDER BY $orderFeild $ordering $limit");
    $rowStmt->execute();
    $rows = $rowStmt->fetchAll();
    return $rows;
}

/**
 * Home Redirect function V2.0
 * [have params]
 * @param $alertType = bootstrap alert type
 * @param $msg= Echo the error msg
 * @param $seconds = seconds before redirecting
 * @param $url = url that redirect to it
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
 * count number of items function v3.0
 * count # of items row in specific [table , condition] 
 * @param $item = colname 
 * @param $tblName = table name
 * @param $condition [optional] 
 * 
 * @return  fetchColumn Numbers
 */
function countItems($item, $tblName , $where = NULL )
{
    global $conn;
    $countStmt = $conn->prepare("SELECT COUNT($item) FROM $tblName $where");
    $countStmt ->execute();
    // numbers of col retreived
    return $countStmt ->fetchColumn();

}

/**
 * getRandomColor function v2.0
 * return random bootstrap calss based on param value
 */
function getRandomColor($value)
{
    // Extrect integer from string
    /* preg_match_all('!\d+!', $value, $matches);
    foreach ($matches as $m) {
        $value = $m[0];
    } */
    // $value = intval($value);
    if ($value >= 1 && $value < 100) {
        return 'primary';
    }elseif ($value >= 100 && $value < 500) {
        return 'warning';
    }elseif ($value >= 500 && $value < 1000) {
        return 'success';
    }elseif ($value >= 1000 && $value < 1500) {
        return 'secondary';
    }elseif ($value >= 1500 && $value < 2000) {
        return 'danger';
    }elseif ($value >= 2000 && $value < 2500) {
        return 'info';
    }elseif ($value >= 2500 && $value < 3000) {
        return 'dark';
    }else {
        return 'light';
    }
}