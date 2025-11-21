<?php
require 'check_session.php';
require 'autoExpire_session.php';
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['p_id'])) {
    $p_id = intval($_POST['p_id']);

    // Optional: Get the file path to delete the file from server
    $stmt = $conn->prepare("SELECT p_path FROM products WHERE p_id = ?");
    $stmt->bind_param("i", $p_id);
    $stmt->execute();
    $stmt->bind_result($filePath);
    $stmt->fetch();
    $stmt->close();

    if ($filePath && file_exists('uploads/products/' . $filePath)) {
        unlink('uploads/products/' . $filePath); // delete the file
    }

    // Delete product from DB
    $stmt = $conn->prepare("DELETE FROM products WHERE p_id = ?");
    $stmt->bind_param("i", $p_id);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Product deleted successfully!";
    } else {
        $_SESSION['error'] = "Failed to delete product!";
    }
    $stmt->close();

    header("Location: product.php");
    exit;
}
?>