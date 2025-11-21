<?php
session_start();
include 'db.php';
require 'secret.php';

if (!$conn) {
    $_SESSION['error'] = "Database connection failed!";
    header("Location: add_ticket.php");
    exit();
}

// Collect Inputs
$date            = trim($_POST['date']);
$ticket_client   = trim($_POST['ticket_client']);  // Name of the client
$product         = trim($_POST['product']);
$complain        = trim($_POST['complain']);
$serial_number   = trim($_POST['serial_number']);
$remark          = trim($_POST['remark']);
$given_by        = trim($_POST['given_by']);
$mobile          = trim($_POST['mobile']);  

// Auto-filled client data
$client_mobile   = trim($_POST['client_mobile']);  // Only mobile needed

// Required Validation
if (empty($date) || empty($ticket_client) || empty($product) || empty($complain) || empty($given_by) || empty($mobile)) {
    $_SESSION['error'] = "All (*) fields are required.";
    header("Location: add_ticket.php");
    exit();
}

// Client mobile validation
if (!preg_match("/^[0-9]{10}$/", $client_mobile)) {
    $_SESSION['error'] = "Enter valid 10-digit client mobile number.";
    header("Location: add_ticket.php");
    exit();
}

// Upload Function
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

// Insert Query
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
    //  SEND SMS ONLY TO CLIENT MOBILE
    // -----------------------------------

    $api_key = $FAST2SMS;

    $sms_message = "Your ticket has been registered.\nClient: $ticket_client\nProduct: $product\nIssue: $complain\n- Support Team";

    $data = array(
        "sender_id" => "TXTIND",
        "message"   => $sms_message,
        "route"     => "v3",
        "numbers"   => $client_mobile
    );

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            "authorization: $api_key",
            "accept: */*",
            "content-type: application/json"
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $_SESSION['success'] = "Ticket added successfully!";
    header("Location: ticket_register.php");

} else {
    $_SESSION['error'] = "Database Error: " . $stmt->error;
    header("Location: add_ticket.php");
}
?>