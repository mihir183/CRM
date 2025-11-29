<?php
session_start();
include 'db.php';
require 'secret.php';

// PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
require '../PHPMailer/Exception.php';

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
$client_email = trim($_POST['email']); // client email
$client_mobile = trim($_POST['client_mobile']); // client email

// Required Validation
if (empty($date) || empty($ticket_client) || empty($product) || empty($complain) || empty($given_by) || empty($mobile) || empty($client_email) || empty($client_mobile)) {
    $_SESSION['error'] = "All (*) fields are required.";
    header("Location: add_ticket.php");
    exit();
}

// Email validation
if (!filter_var($client_email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Enter a valid client email address.";
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
    (date, ticket_client, product, complain, serial_number, remark, img1, img2, img3, given_by, mobile, client_email,client_mobile)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)
");

$stmt->bind_param(
    "sssssssssssss",
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
    $client_email,
    $client_mobile
);

if ($stmt->execute()) {

    // -----------------------------------
    //  SEND EMAIL TO CLIENT USING PHPMailer
    // -----------------------------------
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';   // SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = $sender;            // your email from secret.php
        $mail->Password   = $EPassword;         // your email password from secret.php
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Recipients
        $mail->setFrom($sender, 'Support Team');
        $mail->addAddress($client_email, $ticket_client);

        // Content
        $mail->isHTML(true);
        $mail->Subject = "✅ New Ticket Registered";
        $mail->Body    = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; }
                .ticket-container { background: #f4f4f4; padding: 20px; border-radius: 8px; }
                .ticket-header { background: #007bff; color: white; padding: 10px; border-radius: 5px 5px 0 0; }
                .ticket-body { padding: 10px; }
                .ticket-body p { margin: 5px 0; }
            </style>
        </head>
        <body>
            <div class='ticket-container'>
                <div class='ticket-header'>
                    <h2>New Ticket Registered!</h2>
                </div>
                <div class='ticket-body'>
                    <p><strong>Client:</strong> {$ticket_client}</p>
                    <p><strong>Product:</strong> {$product}</p>
                    <p><strong>Issue:</strong> {$complain}</p>
                    <p><strong>Serial No:</strong> {$serial_number}</p>
                    <p><strong>Remark:</strong> {$remark}</p>
                    <p>Thank you for using our support services.</p>
                </div>
            </div>
        </body>
        </html>
        ";

        $mail->send();
        $_SESSION['success'] = "Ticket added successfully! Email sent to client.";

    } catch (Exception $e) {
        $_SESSION['success'] = "Ticket added successfully! But failed to send email: {$mail->ErrorInfo}";
    }

    header("Location: ticket_register.php");
    exit();

} else {
    $_SESSION['error'] = "Database Error: " . $stmt->error;
    header("Location: add_ticket.php");
    exit();
}
?>