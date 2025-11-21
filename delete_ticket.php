<?php
include 'check_session.php';
include 'db.php';

if (!isset($_GET['t_id'])) {
    die("Invalid Ticket ID");
}

$t_id = $_GET['t_id'];

// Optional: Fetch ticket to delete uploaded images
$stmt = $conn->prepare("SELECT img1, img2, img3 FROM tickets WHERE t_id=?");
$stmt->bind_param("i", $t_id);
$stmt->execute();
$result = $stmt->get_result();
$ticket = $result->fetch_assoc();
$stmt->close();

// Delete images from server if they exist
$uploadPath = "uploads/tickets/";
foreach (['img1', 'img2', 'img3'] as $img) {
    if (!empty($ticket[$img]) && file_exists($uploadPath . $ticket[$img])) {
        unlink($uploadPath . $ticket[$img]);
    }
}

// Delete ticket from database
$del = $conn->prepare("DELETE FROM tickets WHERE t_id=?");
$del->bind_param("i", $t_id);

if ($del->execute()) {
    header("Location: ticket_register.php");
    exit();
} else {
    echo "Error deleting ticket: " . $del->error;
}
?>
