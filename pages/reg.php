<?php include 'CSRF_Token.php' ?>
<!doctype html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
            integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Offline Bootstrap -->
        <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="../assets/css/index.css">
        <!-- Logo (CRM) -->
        <link rel="short icon" href="../assets/images/MNE.png" />
        <title>CRM - Sign Up</title>
    </head>

    <body>

        <!-- Error Alert -->
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show m-3 text-capitalize" role="alert">
                <strong>opps!</strong> <?= $_SESSION['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="container px-3 my-5 pt-4 pb-3 border border-1 rounded-2 shadow-sm">
            <img src="../assets/images/lj_logo.png" class="img-fluid mb-3" alt="Logo" style="max-height: 100px;">

            <h3 class="text-primary text-capitalize mb-2">
                <i class="fa-solid fa-lock me-1"></i> Sign Up
            </h3>

            <form action="connect.php" method="post" onsubmit="beforeSubmit(event)" id="regForm">
                <!-- Username -->
                <label for="user" class="form-label">Username</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa-regular fa-user"></i>
                    </span>
                    <input type="text" id="user" name="user" class="form-control" placeholder="Username"
                        aria-label="Username" required>
                </div>

                <!-- Email -->
                <label for="email" class="form-label">Email</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa-regular fa-envelope"></i>
                    </span>
                    <input type="email" id="email" name="email" class="form-control" placeholder="abc123@gmail.com"
                        aria-label="Email" required>
                </div>

                <!-- Email -->
                <label for="phone" class="form-label">phone</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa-solid fa-phone"></i>
                    </span>
                    <input type="number" id="phone" name="phone" class="form-control" placeholder="1234567890"
                        aria-label="phone" required>
                </div>

                <!-- Password -->
                <label for="pass" class="form-label">Password</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" id="pass" name="pass" class="form-control" placeholder="Password"
                        aria-label="Password" required>
                </div>

                <!-- Confirm Password -->
                <label for="cpass" class="form-label">Confirm Password</label>
                <div class="input-group mb-4">
                    <span class="input-group-text">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" id="cpass" name="cpass" class="form-control" placeholder="Confirm Password"
                        aria-label="Confirm Password" required>
                </div>

                <!-- Hidden CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

                <!-- Submit Button -->
                <button class="btn btn-primary w-100 mb-3 text-capitalize" type="submit">Register</button>

                <!-- Footer -->
                <p class="text-end mb-1">
                    <!-- <i class="fa-solid fa-code me-1"></i> Developed by: <a href="#" class="text-capitalize">Mihir Vaghela</a> -->
                    <i class="fa-solid fa-code me-1"></i> Developed by: <a href="#" class="text-capitalize">lj student</a>
                </p>
                <p class="text-end">
                    Already have an account? <a href="index.php">Login</a>
                </p>
            </form>
        </div>

        <!-- JS -->
        <script src="js/reg.js"></script>

        <!-- Bootstrap JS Bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
            crossorigin="anonymous"></script>
    </body>

</html>