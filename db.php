<?php
$db_host = "localhost";
$db_username = "root";
$db_password = "1234";
$dbname = 'messageBoard';

$conn = new Mysqli($db_host, $db_username, $db_password, $dbname);
$conn->query('set names utf8');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}  
//echo "Connected successfully";


//$sql = "INSERT INTO `context` (`id`, `name`, `context`, `other`) VALUES (NULL, 'test', 'test', '')";
//$res = $conn->query($sql);

?>