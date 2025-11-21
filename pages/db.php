<?php
$server = "localhost";
$user = "root";
$pass = "";
$db = "crm";

// Create connection
$conn = mysqli_connect($server, $user, $pass, $db);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
