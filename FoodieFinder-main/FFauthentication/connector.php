<?php
$host = "localhost";
$db_name = "ff_database";
$username = "root";
$password = ""; 

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    echo json_encode(["message" => "Database connection failed: " . $exception->getMessage()]);
    exit();
}
?>