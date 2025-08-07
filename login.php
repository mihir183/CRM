<?php
include 'db.php';

if ($conn) {

    $user = $_POST['user'];
    $pass = $_POST['pass'];

    if (empty($user) || empty($pass)) {
        echo "<script type='text/javascript'>
            alert('Filled All fields.....!');
            window.location.href='home.php';
            </script>";
    } else {
        // Use php prepared Statment to protect SQL Injection or Hacking...!
        $query = "SELECT * FROM users WHERE email= ? OR username= ? ";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $user, $user);
        mysqli_stmt_execute($stmt);

        // Fetch Username from query to store in session and use......!
        $res = mysqli_stmt_get_result($stmt);

        if ($res && mysqli_num_rows($res) > 0) {

            $row = mysqli_fetch_assoc($res);

            if (password_verify($pass, $row['pass'])) {
                session_start();

                $_SESSION["user"] = $row['username'];
                $_SESSION['last_activity'] = time();

                echo "<script type='text/javascript'>
                    alert('Login Successful...!');
                    window.location.href='home.php';
                    </script>";
                    
            } else {
                session_start();
                $_SESSION['error'] = 'Username OR Password is Invalid';
                header("Location: index.php");
                exit();
            }

        } else {
            session_start();
            $_SESSION['error'] = 'Username OR Password is Invalid';
            header("Location: index.php");
            exit();
        }

        mysqli_stmt_close($stmt);
    }

}
?>