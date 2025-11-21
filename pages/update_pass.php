<?php
session_start();

include 'db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/PHPMailer.php';

$mail = new PHPMailer(true);

if (!empty($_SESSION["email"])) {

    if ($conn) {
        $pass = $_POST["pass"];
        $cpass = $_POST["cpass"];

        if ($pass == $cpass) {
            $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
            $email = $_SESSION['email'];

            $sql = "UPDATE users SET pass = ? WHERE email = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $hashedPass, $email); // match variable name
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

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
                $mail->Body = 'Hi Admin <br><br> Your CRM password has been updated successfully. <br><br>Thanks to use CRM.';

                $mail->send();

                unset($_SESSION['email']);
                $_SESSION['success'] = "Your Password Updated Successfully..!";
                header("Location: index.php");
                exit();

            } catch (Exception $e) {
                $_SESSION['error'] = $mail->ErrorInfo;
                header("Location: forgot.php");
                exit();
            }

        } else {
            $_SESSION['error'] = "Passwords do not match!";
            header("Location: change_pass.php");
            exit();
        }
    }

} else {
    header("Location: index.php");
    exit();
}
?>