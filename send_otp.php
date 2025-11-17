<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/PHPMailer.php';

require 'secret.php';

$mail = new PHPMailer(true);

$email = trim($_POST['email']);

if (!empty($email)) {

    $server = "localhost";
    $user = "root";
    $pass = "";
    $db = "crm";

    $conn = mysqli_connect($server, $user, $pass, $db);

    $existUser = "SELECT * FROM users WHERE email = '$email'";
    $run = mysqli_query($conn, $existUser);

    if (mysqli_num_rows($run) > 0) {

        $otp = rand(1000, 9999);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $sender;   // Your Gmail
            $mail->Password = $EPassword;    // App Password only
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use TLS
            $mail->Port = 587;

            $mail->setFrom($sender, 'CRM');
            $mail->addAddress($email, 'User');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Reset your CRM login Password.';
            $mail->Body = 'Hi <br> to Reset your CRM account password, enter below varification code. <br><br> ' . $otp . '<br><br>Note: If you enter wrong otp so generate new otp this otp not use in twice.. <br>Thanks to use CRM.';

            $mail->send();
            $_SESSION['otp'] = $otp;
            $_SESSION['email'] = $email;
            header("Location: otp.php");
            exit();

        } catch (Exception $e) {
            $_SESSION['error'] = $mail->ErrorInfo;
            header("Location: forgot.php");
            exit();
        }

    } else {
        $_SESSION['error'] = $email . ' is not found in database...!';
        header("Location: forgot.php");
        exit();
    }

} else {
    $_SESSION['error'] = 'Enter Valid Email....!';
    header("Location: forgot.php");
    exit();
}
?>