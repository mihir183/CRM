<?php
session_start();
?>
<!doctype html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
            integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <!-- FontAwsome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
            integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />

        <link rel="stylesheet" href="assets/css/index.css">

        <title>CRM</title>
    </head>

    <body>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Hello Admin!</strong> <?= $_SESSION['success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <div class="container px-3 my-5 pt-3 pb-2 border border-1 rounded rounded-2">
            <img src="assets/images/lj_logo.png" class="px-2" alt="" width="100%" height="100">
            <h3 class="mt-3 text-primary text-capitalize">
                <i class="fa-solid fa-lock"></i>
                sign in
            </h3>
            <p class="my-2 text-capitalize fs-4">wipra staff</p>
            <form action="login.php" method="post">

                <label for="user">Username</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-regular fa-user"></i>
                    </span>
                    <input type="text" id="user" name="user" class="form-control" placeholder="Username"
                        aria-label="Username" aria-describedby="basic-addon1" autofocus Required>
                </div>

                <label for="pass">Password</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-regular fa-user"></i>
                    </span>
                    <input type="password" id="pass" name="pass" class="form-control" placeholder=""
                        aria-label="Username" aria-describedby="basic-addon1" Required>
                </div>

                <div class="form-check text-center mb-1">
                    <a href="forgot.php">Forgot password?</a>
                </div>

                <button class="mb-2 btn btn-primary w-100 mt-2 text-capitalize">secured sign in</button>

                <p class="text-right mt-2 mb-0">
                    <i class="fa-solid fa-code"></i> developed by : <a href="#">Mihir Vaghela</a>
                </p>
                <p class="text-right mb-1">
                    Don't have an account? <a href="reg.php">Sign up</a>
                </p>
            </form>
        </div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
            crossorigin="anonymous"></script>
    </body>

</html>