<?php
session_start();
// initialize php file
include 'init.php';

$stmt1 = $conn->prepare("SELECT * FROM categories");
$stmt1->execute();
$cats = $stmt1->fetchAll();
foreach ($cats as $cat ) {
    echo $cat['name'] . "<br>";
}

include $tpl . 'footer.php'
?>