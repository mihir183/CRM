<?php
session_start();
include 'db.php';
require 'secret.php';

// -----------------------------------
//  TWILIO CONFIG
// -----------------------------------
require __DIR__ . '../vendor/autoload.php';
use Twilio\Rest\Client;

$twilio_sid      = $SID;          // change
$twilio_token    = $TTOKEN;           // change
$twilio_whatsapp = "whatsapp:+14155238886";     // Twilio sandbox number


if (!$conn) {
    $_SESSION['error'] = "Database connection failed!";
    header("Location: add_ticket.php");
    exit();
}

// Collect Inputs
$date = trim($_POST['date']);
$ticket_client = trim($_POST['ticket_client']);
$product = trim($_POST['product']);
$complain = trim($_POST['complain']);
$serial_number = trim($_POST['serial_number']);
$remark = trim($_POST['remark']);
$given_by = trim($_POST['given_by']);
$mobile = trim($_POST['mobile']);

// Only client mobile needed
$client_mobile = trim($_POST['client_mobile']);

// Required Validation
if (empty($date) || empty($ticket_client) || empty($product) || empty($complain) || empty($given_by) || empty($mobile)) {
    $_SESSION['error'] = "All (*) fields are required.";
    header("Location: add_ticket.php");
    exit();
}

// Mobile Number Validation
if (!preg_match("/^[0-9]{10}$/", $client_mobile)) {
    $_SESSION['error'] = "Enter valid 10-digit client mobile number.";
    header("Location: add_ticket.php");
    exit();
}


// -----------------------------------
//  FILE UPLOAD FUNCTION
// -----------------------------------
function uploadImage($key)
{
    if (!isset($_FILES[$key]) || $_FILES[$key]['error'] !== UPLOAD_ERR_OK) {
        return "";
    }

    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
    $ext = strtolower(pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        return "";
    }

    $uploadDir = __DIR__ . "/uploads/tickets/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = time() . "_" . uniqid() . "." . $ext;
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES[$key]['tmp_name'], $filePath)) {
        return $fileName;
    } else {
        return "";
    }
}


// Upload images
$img1 = uploadImage('img1');
$img2 = uploadImage('img2');
$img3 = uploadImage('img3');


// -----------------------------------
//  DATABASE INSERT
// -----------------------------------
$stmt = $conn->prepare("
    INSERT INTO tickets 
    (date, ticket_client, product, complain, serial_number, remark, img1, img2, img3, given_by, mobile, client_mobile)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "ssssssssssss",
    $date,
    $ticket_client,
    $product,
    $complain,
    $serial_number,
    $remark,
    $img1,
    $img2,
    $img3,
    $given_by,
    $mobile,
    $client_mobile
);

if ($stmt->execute()) {

    // -----------------------------------
    //  SEND WHATSAPP MESSAGE USING TWILIO
    // -----------------------------------

    $client = new Client($twilio_sid, $twilio_token);

    $to_whatsapp = "whatsapp:+91" . $client_mobile;

    $message_text =
        "✅ *New Ticket Registered!*\n\n" .
        "🧑 Client: $ticket_client\n" .
        "📦 Product: $product\n" .
        "⚠ Issue: $complain\n" .
        "🔢 Serial No: $serial_number\n" .
        "📝 Remark: $remark\n\n" .
        "Thank you.\n- Support Team";

    try {
        $message = $client->messages->create(
            $to_whatsapp,
            [
                'from' => $twilio_whatsapp,
                'body' => $message_text
            ]
        );

        $_SESSION['success'] = "Ticket added successfully! WhatsApp message sent.";

    } catch (Exception $e) {
        $_SESSION['error'] = "Ticket added but WhatsApp failed: " . $e->getMessage();
    }

    header("Location: ticket_register.php");
    exit();

} else {

    $_SESSION['error'] = "Database Error: " . $stmt->error;
    header("Location: add_ticket.php");
    exit();
}
?>