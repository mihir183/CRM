<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/PHPMailer.php';

$mail = new PHPMailer(true);
include 'db.php';

if ($conn) {

    $user = trim($_POST['user'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass = trim($_POST['pass'] ?? '');
    // $cpass = trim($_POST['cpass'] ?? '');
    // $mob = trim($_POST['mob'] ?? '');

    if(empty($user) || empty($email) || empty($pass)){
        header("Location: reg.php");
        exit();
    }else{
        // check the user if he/her already exist or not...!
        $existUser = "SELECT * FROM users WHERE email = '$email' OR username = '$user'";
        $run = mysqli_query($conn, $existUser);

        if (mysqli_num_rows($run) > 0) {

            echo "<script type='text/javascript'>
            alert('User already exists or email is taken.');
            window.location.href='reg.php';
            </script>";
            exit();

        } else {
            $hashpass = password_hash($pass, PASSWORD_DEFAULT);

            $query = "INSERT INTO users (username,email,pass)VALUES('$user','$email','$hashpass')";
            $result = mysqli_query($conn, $query);

            if ($result) {

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
                    $mail->Subject = 'Registration of CRM';
                    $mail->Body = 'Hi ' . $user . '<br> You are successfully completed your registration in CRM.<br><br>Thanks to use CRM.';

                    $mail->send();
                    $_SESSION["user"] = $user;
                    echo "<script type='text/javascript'>
                        alert('Register Successful..!');
                        window.location.href='home.php';
                        </script>";

                } catch (Exception $e) {
                    $_SESSION['error'] = $mail->ErrorInfo;
                    header("Location: reg.php");
                    exit();
                }
            } else {
                echo "<script type='text/javascript'>
                alert('Register Failed..!');
                window.location.href='reg.php';
                </script>";
            }
        }
    }
    

    // $query = "SELECT * FROM users WHERE email='$user' AND pass='$pass'";
    // $run = mysqli_query($conn, $query);

    // if(mysqli_num_rows($run)>0)
    // {
    //     echo "<script type='text/javascript'>
    //     alert('Login Successful...!');
    //     window.location.href='home.php';
    //     </script>";
    // }else{
    //     echo "<script type='text/javascript'>
    //     alert('Login Fail...!');
    //     window.location.href='index.php';
    //     </script>";
    // }
}
?>