<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>
<body>

    <?php
    if (!empty($_SESSION['error'])) {
        echo '<div class="mt-2 mx-3 alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Hello Admin!</strong> ' . $_SESSION['error'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        unset($_SESSION['error']);
    }
    ?>

    <div class="container w-25 mt-5 py-3">
        <h2 class="text-capitalize text-center mb-4">reset password</h2>
        <form action="send_otp.php" method="post" class="d-flex flex-column justify-content-center">
            <input type="email" class="form-control mb-2" name="email" placeholder="Enter Email" autofocus required>
            <button class="center mt-2 mb-3 btn btn-primary text-capitalize w-auto">Send OTP</button>
        </form>
        <a href="index.php">
            <button class="center btn btn-primary text-capitalize w-100">back</button>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
</body>
</html>
