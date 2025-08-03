<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/PHPMailer.php';

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
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;              //Enable verbose debug output
            $mail->isSMTP();                                    //Send using SMTP
            $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth = true;                             //Enable SMTP authentication
            $mail->Username = 'mihirvaghela1811@gmail.com';     //SMTP username
            $mail->Password = 'lhwn dpyi awzt vpuy';            //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;    //Enable implicit TLS encryption
            $mail->Port = 465;                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('mihirvaghela1811@gmail.com', 'CRM');
            $mail->addAddress($email, 'User');     //Add a recipient


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