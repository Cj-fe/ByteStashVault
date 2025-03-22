<?php 

$servername = "localhost";
$username = "root";
$password = "K1Csy82GuKf3b3nq";
$db = "password_manager_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Failed " . $e->getMessage();
}

?>