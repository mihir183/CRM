<?php
session_start();
?>
<!doctype html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap 5.3.7 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
            integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Custom CSS -->
        <link rel="stylesheet" href="assets/css/index.css">

        <!-- Logo (CRM) -->
        <link rel="short icon" href="assets/images/MNE.png" />

        <title>CRM</title>
    </head>

    <body>

        <!-- Error Alert -->
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-warning alert-dismissible fade show m-3" role="alert">
                <strong>Oops!</strong> <?= $_SESSION['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="container my-5 p-4 border rounded-3 shadow-sm ">
            <img src="assets/images/lj_logo.png" class="mb-3" alt="LJ Logo" width="100%" height="100">
            <h3 class="text-primary text-capitalize mb-1">
                <i class="fa-solid fa-lock"></i> Sign In
            </h3>
            <p class="mb-3 fs-5 text-muted">LJ student</p>

            <form action="login.php" method="post">

                <!-- Username -->
                <div class="mb-3">
                    <label for="user" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text" id="user-addon">
                            <i class="fa-regular fa-user"></i>
                        </span>
                        <input type="text" id="user" name="user" class="form-control" placeholder="Enter username"
                            aria-label="Username" aria-describedby="user-addon" required autofocus>
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="pass" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text" id="pass-addon">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" id="pass" name="pass" class="form-control" placeholder="Enter password"
                            aria-label="Password" aria-describedby="pass-addon" required>
                    </div>
                </div>

                <!-- Forgot Password -->
                <div class="text-center mb-3">
                    <a href="forgot.php">Forgot password?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100 text-capitalize">Secured Sign In</button>

                <!-- Footer -->
                <div class="text-end mt-4">
                    <p class="mb-1">
                        <!-- <i class="fa-solid fa-code"></i> Developed by: <a href="#">Mihir Vaghela</a> -->
                        <i class="fa-solid fa-code"></i> Developed by: <a href="#">LJ Student</a>
                    </p>
                    <p class="mb-0">
                        Don't have an account? <a href="reg.php">Sign up</a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Bootstrap 5 JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
            crossorigin="anonymous"></script>
    </body>

</html>