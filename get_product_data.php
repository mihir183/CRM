<?php
include 'db.php';

if (!isset($_GET['p_id'])) {
    echo json_encode(['success' => false]);
    exit;
}

$p_id = $_GET['p_id'];

$sql = "SELECT p_name, variant, product_key,licence_key FROM products WHERE p_id = '$p_id'";
$res = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($res)) {
    echo json_encode([
        'success' => true,
        'data' => $row
    ]);
} else {
    echo json_encode(['success' => false]);
}
?>
