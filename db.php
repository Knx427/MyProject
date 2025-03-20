<?php

$dsn = "mysql:host=localhost;dbname=blog_db;charset=utf8";
$user = "root";
$pass = "";

try{
    $conn = new PDO($dsn, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("Connection failed: " . $e->getMessage());
}