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
 * getAllRows() function v2.0 - 
 * get ultimate function without INNER JOIN
 * @param selectCols  $select = col to selected
 * @param tableName  $tblName = table [EX: users , items , categories]
 * @param where [optional default value = null] 
 * @param and [and condition in query - optional default value = null] 
 * @param orderFeild  
 * @param ordering
 *  
 * @return allTableRows 
 */
function getAllRows($select, $tblName, $where = NULL , $and = NULL , $orderFeild = 'created_at' , $ordering = 'DESC')
{
    global $conn;
    $rowStmt = $conn->prepare("SELECT $select FROM $tblName
                               $where $and ORDER BY $orderFeild $ordering");
    $rowStmt->execute();
    $rows = $rowStmt->fetchAll();
    return $rows;
}

/**
 * get comments records function v4.0
 * v3.0 update:-
 *  - add inner join to display comment (category , username)
 *  - when calling method you must path $where attr (colName) with table (Ex: comments.user_id )
 *   to avoid fatal error (colname ambugios) 
 * @return rows
 */
function getComments($where , $value, $condition = '')
{
    global $conn;
    $getComments = $conn->prepare("SELECT comments.* , users.username, items.name AS item_name 
                                    FROM comments
                                    INNER JOIN users ON users.user_id = comments.user_id 
                                    INNER JOIN items ON items.item_id = comments.item_id 
                                    WHERE $where = ? $condition
                                    ORDER BY created_at DESC");
    $getComments->execute(array($value));
    $comments = $getComments->fetchAll();
    return $comments;
}


/* function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
} */

function time_Ago($time) { 
  
    // Calculate difference between current 
    // time and given timestamp in seconds 
    $diff     = time() - $time; 
      
    // Time difference in seconds 
    $sec     = $diff; 
      
    // Convert time difference in minutes 
    $min     = round($diff / 60 ); 
      
    // Convert time difference in hours 
    $hrs     = round($diff / 3600); 
      
    // Convert time difference in days 
    $days     = round($diff / 86400 ); 
      
    // Convert time difference in weeks 
    $weeks     = round($diff / 604800); 
      
    // Convert time difference in months 
    $mnths     = round($diff / 2600640 ); 
      
    // Convert time difference in years 
    $yrs     = round($diff / 31207680 ); 
      
    // Check for seconds 
    if($sec <= 60) { 
        echo "$sec seconds ago"; 
    } 
      
    // Check for minutes 
    else if($min <= 60) { 
        if($min==1) { 
            echo "one minute ago"; 
        } 
        else { 
            echo "$min minutes ago"; 
        } 
    } 
      
    // Check for hours 
    else if($hrs <= 24) { 
        if($hrs == 1) {  
            echo "an hour ago"; 
        } 
        else { 
            echo "$hrs hours ago"; 
        } 
    } 
      
    // Check for days 
    else if($days <= 7) { 
        if($days == 1) { 
            echo "Yesterday"; 
        } 
        else { 
            echo "$days days ago"; 
        } 
    } 
      
    // Check for weeks 
    else if($weeks <= 4.3) { 
        if($weeks == 1) { 
            echo "a week ago"; 
        } 
        else { 
            echo "$weeks weeks ago"; 
        } 
    } 
      
    // Check for months 
    else if($mnths <= 12) { 
        if($mnths == 1) { 
            echo "a month ago"; 
        } 
        else { 
            echo "$mnths months ago"; 
        } 
    } 
      
    // Check for years 
    else { 
        if($yrs == 1) { 
            echo "one year ago"; 
        } 
        else { 
            echo "$yrs years ago"; 
        } 
    } 
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
 * Home Redirect function V2.0
 * [have params]
 * @param $alertType = bootstrap alert type
 * @param $msg= Echo the error msg
 * @param $seconds = seconds before redirecting
 * @param $url = url that redirect to it
 */
function redirect2Home($alertType, $msg, $seconds = 3, $url = 'index.php')
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
 * count number of items function v2.0
 * count # of items row in specific [table , condition] 
 * @param $item = colname 
 * @param $tblName = table name
 * @param $condition [optional] 
 * 
 * @return  fetchColumn Numbers
 */
function countItems($item, $tblName , $condition = '')
{
    global $conn;
    $countStmt = $conn->prepare("SELECT COUNT($item) FROM $tblName $condition");
    $countStmt ->execute();
    // numbers of col retreived
    return $countStmt ->fetchColumn();

}


/**
 * subDescription() fucn v1.0
 * @param string
 * @return substring
 * 
 * 
 */

function subDescription($string)
 {
   
    if (strlen($string) > 66) {
        // truncate string
        $stringCut = substr($string, 0, 66);
        $endPoint = strrpos($stringCut, ' ');
    
        //if the string doesn't contain any space then it will cut without word basis.
        $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
        $string .= '... <a href="#">Read More</a>';
    }
    return $string;
 }

 function subProdTitle($string)
 {
    if (strlen($string) > 40) {
        // truncate string
        $stringCut = substr($string, 0, 40);
        $endPoint = strrpos($stringCut, ' ');
    
        //if the string doesn't contain any space then it will cut without word basis.
        $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
        $string .= '...';
    }
    return $string;
 }




 















/** back-end funcs */



/**
 * get latest record function v1.0
 * $select = col to selected 
 * $tblName = table [EX: users , items , categories]
 * $order = col to order by it
 * $limit = number of records to get  [optional]
 * 
 * @return rows
 */
function getLatest($select, $tblName , $order , $limit = 5)
{
    global $conn;
    $latestStmt = $conn->prepare("SELECT $select FROM $tblName ORDER BY $order DESC LIMIT $limit");
    $latestStmt->execute();
    $rows = $latestStmt->fetchAll();
    return $rows;
}



/**
 * getRandomColor function v1.0
 * return random bootstrap calss based on param value
 */
function getRandomColor($value)
{
    // Extrect integer from string
    preg_match_all('!\d+!', $value, $matches);
    foreach ($matches as $m) {
        $value = $m[0];
    }
    $value = intval($value);
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