<?php 
session_start();

$otp = $_POST["otp"];

if($otp == $_SESSION['otp'])
{
    unset($_SESSION['otp']);
    header("Location: change_pass.php");
    exit();
}else{
    $_SESSION['error'] = 'OTP does not match. Generate Once Again....!';
    unset($_SESSION['otp']);
    header("Location: forgot.php");
    exit();
}

?>