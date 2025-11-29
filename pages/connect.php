<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/SMTP.php';
require '../PHPMailer/PHPMailer.php';

$mail = new PHPMailer(true);

require 'db.php';
require 'secret.php';

if ($conn) {

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("Invalid CSRF token.");
            header("Location: reg.php");
            exit();
        } else {
            // ✅ Token is valid — proceed with form processing

            $user = trim($_POST['user'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $pass = trim($_POST['pass'] ?? '');
            $cpass = trim($_POST['cpass'] ?? '');
            // $mob = trim($_POST['mob'] ?? '');

            if (empty($user) || empty($email) || empty($phone) || empty($pass) || $pass !== $cpass) {
                session_start();
                $_SESSION['error'] = 'invalid enter data..!';
                header("Location: reg.php");
                exit();
            } else {
                // check the user if he/her already exist or not...!
                $existUser = "SELECT * FROM users WHERE email = ? OR username = ? ";
                $stmt = mysqli_prepare($conn, $existUser);
                mysqli_stmt_bind_param($stmt, "ss", $email, $user);
                mysqli_stmt_execute($stmt);

                $run = mysqli_stmt_get_result($stmt);

                if ($run && mysqli_num_rows($run) > 0) {

                    $_SESSION['error'] = '(' . $email . ') this user alredy registred..!';
                    header("Location: reg.php");
                    exit();

                } else {
                    $hashpass = password_hash($pass, PASSWORD_DEFAULT);
                    $createdDate = date("Y-m-d H:i:s");

                    $query = "INSERT INTO users (username,email,pass,phone,created_user_date)VALUES(?,?,?,?,?)";
                    $stmt = mysqli_prepare($conn, $query);
                    $stmt->bind_param("sssis", $user, $email, $hashpass, $phone,$createdDate);
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {

                        try {
                            //Server settings
                            $mail->SMTPDebug = SMTP::DEBUG_SERVER;              //Enable verbose debug output
                            $mail->isSMTP();                                    //Send using SMTP
                            $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
                            $mail->SMTPAuth = true;                             //Enable SMTP authentication
                            $mail->Username = $sender;
                            $mail->Password = $EPassword;
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;    //Enable implicit TLS encryption
                            $mail->Port = 465;                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                            //Recipients
                            $mail->setFrom($sender, 'CRM');
                            $mail->addAddress($email, 'User');     //Add a recipient

                            //Content
                            $mail->isHTML(true);                                  //Set email format to HTML
                            $mail->Subject = 'Registration of CRM';
                            $mail->Body = '
                                <div style="max-width:600px;margin:auto;padding:20px;background:#f7f7ff;font-family:Arial,Helvetica,sans-serif;border-radius:10px;border:1px solid #e0e0e0;">
                                    
                                    <div style="text-align:center;padding:20px 0;">
                                        <h2 style="color:#4A4AFF;margin:0;">🎉 Welcome to CRM!</h2>
                                    </div>

                                    <div style="background:white;padding:25px;border-radius:10px;border:1px solid #ddd;">
                                        <p style="font-size:16px;color:#333;margin-bottom:15px;">Hi <strong>' . $user . '</strong>,</p>

                                        <p style="font-size:15px;color:#555;line-height:1.6;">
                                            We are excited to inform you that your registration in <strong>CRM</strong> has been successfully completed.  
                                            Thank you for joining us! You now have full access to our CRM platform.
                                        </p>

                                        <div style="margin:25px 0;text-align:center;">
                                            <a href="http://localhost/CRM/pages/index.php" 
                                            style="background:#4A4AFF;color:white;padding:12px 25px;border-radius:8px;text-decoration:none;font-size:15px;">
                                            Go to Dashboard
                                            </a>
                                        </div>

                                        <p style="font-size:14px;color:#555;line-height:1.6;">
                                            If you have any questions or need support, feel free to reply to this email.
                                        </p>

                                        <p style="font-size:15px;color:#333;margin-top:30px;">Thanks for using CRM!<br><strong>Team CRM</strong></p>
                                    </div>

                                    <div style="text-align:center;margin-top:25px;color:#888;font-size:12px;">
                                        © ' . date("Y") . ' CRM. All rights reserved.
                                    </div>
                                </div>';

                            $mail->send();
                            $_SESSION["user"] = $user;
                            echo "<script type='text/javascript'>
                                alert('Register Successful..!');
                                window.location.href='index.php';
                                </script>";

                        } catch (Exception $e) {
                            $_SESSION['error'] = $mail->ErrorInfo;
                            header("Location: reg.php");
                            exit();
                        }
                    } else {
                        $_SESSION['error'] = 'Registration fail. please try again.';
                        header("Location: reg.php");
                        exit();
                    }
                }
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