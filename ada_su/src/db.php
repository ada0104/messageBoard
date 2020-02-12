<?php

class DBCONNET
{
 public function dbconnet ()
 {
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpasswd = "1234";
    $dbname = 'messageBoard';
    $dsn = "mysql:host=".$dbhost.";dbname=".$dbname;
    try
    {
        global $conn;
        $conn = new PDO($dsn,$dbuser,$dbpasswd);
        $conn->exec("SET CHARACTER SET utf8");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        echo "Connection failed: ".$e->getMessage();
    }
 }
};




