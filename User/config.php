<?php
//database/config.php
//Database connection settings
$host = "localhost";
$user = "root";
$pass = "root";      
$db   = "event_booking";
//Create connection to MySQL database
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
