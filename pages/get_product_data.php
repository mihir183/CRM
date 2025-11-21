<?php
include 'db.php';

if (isset($_GET['p_id'])) {
    $p_id = intval($_GET['p_id']);
    $stmt = $conn->prepare("SELECT variant, product_key, licence_key FROM products WHERE p_id = ?");
    $stmt->bind_param("i", $p_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(['success' => true, 'data' => $row]);
    } else {
        echo json_encode(['success' => false]);
    }
}
