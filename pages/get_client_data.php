<?php
require 'db.php';

header('Content-Type: application/json');

if (!isset($_GET['key_person'])) {
    echo json_encode(['success' => false, 'message' => 'Missing key_person']);
    exit;
}

$key_person = $_GET['key_person'];

$query = "SELECT * FROM client WHERE key_person = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $key_person);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $client = $result->fetch_assoc();
    echo json_encode(['success' => true, 'client' => $client]);
} else {
    echo json_encode(['success' => false, 'message' => 'No client found']);
}
