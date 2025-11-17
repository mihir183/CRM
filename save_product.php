<?php
require 'check_session.php';
require 'autoExpire_session.php';
include 'db.php';

// Validate
if (empty($_POST['p_name']) || !isset($_FILES['p_file'])) {
    die("Invalid Input");
}

$p_name = trim($_POST['p_name']);

// Upload file
$allowed = ['zip','msi','exe','pdf','rar','txt','jpg','png'];

$ext = strtolower(pathinfo($_FILES['p_file']['name'], PATHINFO_EXTENSION));

if (!in_array($ext, $allowed)) {
    die("Invalid file type!");
}

$newName = time() . "_" . uniqid() . "." . $ext;

$uploadPath = "uploads/products/";

if (!is_dir($uploadPath)) {
    mkdir($uploadPath, 0777, true);
}

move_uploaded_file($_FILES['p_file']['tmp_name'], $uploadPath . $newName);

// Insert into DB
$stmt = $conn->prepare("INSERT INTO products (p_name, p_path) VALUES (?, ?)");
$stmt->bind_param("ss", $p_name, $newName);

if ($stmt->execute()) {
    header("Location: product.php");
    exit();
} else {
    echo "DB Error: " . $stmt->error;
}
