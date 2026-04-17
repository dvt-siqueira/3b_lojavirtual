<?php
// Database configuration
$host = 'localhost'; // Database host
$db = '3b_lojavirtual'; // Database
$user = 'root'; // Database username
$pass = ''; // Database password
$charset = 'utf8mb4'; // Database charset
 
// Data Source Name
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";  

$option = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
];


try {
    $pdo = new PDO($dsn, $user, $pass, $option);
    //echo "Connected successfully";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>