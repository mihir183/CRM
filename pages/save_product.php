<?php
require 'check_session.php';
require 'autoExpire_session.php';
include 'db.php';

// Validate required fields
if (empty($_POST['p_name']) || empty($_POST['variant']) || empty($_POST['product_key']) || empty($_POST['licence_key']) || !isset($_FILES['p_file'])) {
    die("Invalid Input");
}

// Collect form data
$p_name = trim($_POST['p_name']);
$variant = trim($_POST['variant']);
$product_key = trim($_POST['product_key']);
$licence_key = trim($_POST['licence_key']);

// Upload file
$allowed = ['zip','msi','exe','pdf','rar','txt','jpg','png'];
$ext = strtolower(pathinfo($_FILES['p_file']['name'], PATHINFO_EXTENSION));

if (!in_array($ext, $allowed)) {
    die("Invalid file type!");
}

$newName = time() . "_" . uniqid() . "." . $ext;
$uploadPath = "../uploads/products/";

if (!is_dir($uploadPath)) {
    mkdir($uploadPath, 0777, true);
}

move_uploaded_file($_FILES['p_file']['tmp_name'], $uploadPath . $newName);

// Insert into DB
$stmt = $conn->prepare("INSERT INTO products (p_name, p_path, variant, product_key, licence_key) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $p_name, $newName, $variant, $product_key, $licence_key);

if ($stmt->execute()) {
    header("Location: add_product.php");
    exit();
} else {
    echo "DB Error: " . $stmt->error;
}
?>