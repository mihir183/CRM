<?php
include 'db.php';

if ($conn){

    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $query = "SELECT * FROM users WHERE (email='$user' OR username='$user') AND pass='$pass'";
    $run = mysqli_query($conn, $query);

    // Fetch Username from query to store in session and use......!
    $row = mysqli_fetch_assoc($run);

    if ($run && mysqli_num_rows($run) > 0) {
        session_start();
        $_SESSION["user"] = $row['username'];
        $_SESSION['last_activity'] = time();
        echo "<script type='text/javascript'>
        alert('Login Successful...!');
        window.location.href='home.php';
        </script>";
    } else {
        $_SESSION['error']='Username OR Password is Invalid';
        header("Location: index.php");
        exit();
    }
}
?>