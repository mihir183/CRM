<?php
require 'db.php';
session_start();
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
    exit();
}

$cid = $_POST['cid'];
$company = $_POST['company'];
$city = $_POST['city'];
$country = $_POST['country'];
$mobile = $_POST['mobile'];
$address = $_POST['address'];
$email = $_POST['email'];
$key = $_POST['key'];
$phone = $_POST['phone'];
$pin = $_POST['pin'];
$product = $_POST['product'];
$variant = $_POST['variant'];
$p_key = $_POST['p_key'];
$l_key = $_POST['l_key'];

$utime = date("Y-m-d H:i:s");

$stmt = $conn->prepare("UPDATE client SET company_name = ?, city = ?, country = ?, mobile = ?, address = ?, email = ?, key_person = ?, phone = ?, pin = ?, product = ?, variant = ?, p_key = ?, l_key = ?, update_ctime = ? WHERE cid = ?");

$stmt->bind_param("sssssssssssssss",$company,$city,$country,$mobile,$address,$email,$key,$phone,$pin,$product,$variant,$p_key,$l_key,$utime,$cid);

if($stmt->execute()){
    $_SESSION['success'] = 'Client successfully updated';
    header("Location: client.php");
    exit();
}else{
    $_SESSION['error'] = 'Client not updated';
    header("Location: edit_client.php?cid=".$cid);
    exit();
}
?>