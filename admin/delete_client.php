<?php
session_start();
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($conn) {
        // Prepare delete statement
        $stmt = $conn->prepare("DELETE FROM client WHERE cid = ?");
        $stmt->bind_param("s", $id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Client deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete client!";
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "Database connection failed!";
    }
} else {
    $_SESSION['error'] = "Invalid client ID!";
}

// Redirect back to client list page
header("Location: clients.php");
// exit;
?>
