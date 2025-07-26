<?php
$host = "localhost";
$user = "root";
$pass = ""; // Use your MySQL password
$db   = "query-system";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
