<?php
include 'db.php';

if (isset($_GET['p_name'])) {

    $p_name = $_GET['p_name']; // keep string, do NOT use intval()

    $stmt = $conn->prepare("SELECT variant, product_key, licence_key 
                            FROM products 
                            WHERE p_name = ?");
    $stmt->bind_param("s", $p_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(['success' => true, 'data' => $row]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
}
?>
