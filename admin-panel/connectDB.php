<?php
// Data source name
$dsn = "mysql:host=localhost;dbname=shop";
$user = "root";
$password = "123456";
// for arabic fields inputs
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

try {
    // start new connection with DB
    $conn = new PDO($dsn, $user, $password, $options);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo 'Connection successfully <br />';

} catch (PDOException $e) {
    echo 'Connection Failed: ' . $e->getMessage();
}
