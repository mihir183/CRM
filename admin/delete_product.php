<?php
include 'db.php';

if (isset($_GET['id'])) {

    $p_id = intval($_GET['id']);

    // get file
    $stmt = $conn->prepare("SELECT p_path FROM products WHERE p_id = ?");
    $stmt->bind_param("i", $p_id);
    $stmt->execute();
    $stmt->bind_result($filePath);
    $stmt->fetch();
    $stmt->close();

    if ($filePath && file_exists('../uploads/products/' . $filePath)) {
        unlink('../uploads/products/' . $filePath);
    }

    // delete product
    $stmt = $conn->prepare("DELETE FROM products WHERE p_id = ?");
    $stmt->bind_param("i", $p_id);
    $stmt->execute();
    $stmt->close();

    header("Location: product.php");
    exit;
}
?>
