<?php

// Database connection
$host = "localhost";
$dbname = "emenu";
$username = "root";
$password = "";

try {
    //$con = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, $options);
    $conn = new PDO("mysql:host=$host", $username, $password);
    $sql = "CREATE DATABASE IF NOT EXISTS emenu CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    
    $conn->exec($sql);
    echo "database connected.";

} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

?>