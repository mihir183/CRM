<?php
require 'db.php';
session_start();

$out_time = date("d-m-Y H:i:s");

$query = "UPDATE login_logs SET out_time=? where name=?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ss',$out_time,$_SESSION['user']);
$stmt->execute();
$stmt->close();

session_unset();
session_destroy();
header("Location: index.php");
?>