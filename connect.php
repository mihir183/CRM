<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/PHPMailer.php';

$mail = new PHPMailer(true);

require 'db.php';
require 'secret.php';

if ($conn) {

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("Invalid CSRF token.");
            header("Location: reg.php");
            exit();
        }else{
            // ✅ Token is valid — proceed with form processing

            $user = trim($_POST['user'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $pass = trim($_POST['pass'] ?? '');
            $cpass = trim($_POST['cpass'] ?? '');
            // $mob = trim($_POST['mob'] ?? '');
        
            if(empty($user) || empty($email) || empty($pass) || $pass !== $cpass){
                session_start();
                $_SESSION['error'] = 'invalid enter data..!';
                header("Location: reg.php");
                exit();
            }else{
                // check the user if he/her already exist or not...!
                $existUser = "SELECT * FROM users WHERE email = ? OR username = ? ";
                $stmt = mysqli_prepare($conn,$existUser);
                mysqli_stmt_bind_param($stmt,"ss",$email,$user);
                mysqli_stmt_execute($stmt);
        
                $run =  mysqli_stmt_get_result($stmt);
        
                if ($run && mysqli_num_rows($run) > 0) {
        
                    $_SESSION['error'] = '('.$email.') this user alredy registred..!';
                    header("Location: reg.php");
                    exit();
        
                } else {
                    $hashpass = password_hash($pass, PASSWORD_DEFAULT);
        
                    $query = "INSERT INTO users (username,email,pass)VALUES(?,?,?)";
                    $stmt = mysqli_prepare($conn,$query);
                    $stmt->bind_param("sss",$user,$email,$hashpass);
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