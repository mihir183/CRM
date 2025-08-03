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

        <div class="container px-3 my-3 pt-3 pb-1 border border-1 rounded rounded-2">
            <img src="assets/images/lj_logo.png" class="px-2" alt="" width="100%" height="100">
            <h3 class="mt-3 text-primary text-capitalize">
                <i class="fa-solid fa-lock"></i>
                sign up
            </h3>
            <form action="connect.php" method="post" onsubmit="beforeSubmit(event)" id="regForm">
                <label for="user">Username</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-regular fa-user"></i>
                    </span>
                    <input type="text" id="user" name="user" class="form-control" placeholder="Username"
                        aria-label="Username" aria-describedby="basic-addon1" autofocus required>
                </div>

                <label for="email">Email</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-regular fa-user"></i>
                    </span>
                    <input type="email" id="email" name="email" class="form-control" placeholder="abc123@gmail.com"
                        aria-label="Username" aria-describedby="basic-addon1" autofocus required>
                </div>

                <label for="pass">Password</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" id="pass" name="pass" class="form-control" placeholder=""
                        aria-label="Username" aria-describedby="basic-addon1" required>
                </div>

                <label for="cpass">Comfirm Password</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" id="cpass" name="cpass" class="form-control" placeholder=""
                        aria-label="Username" aria-describedby="basic-addon1" required>
                </div>

                <button class="mb-2 btn btn-primary w-100 mt-2 text-capitalize">register</button>

                <p class="text-right mt-1 mb-0">
                    <i class="fa-solid fa-code"></i> developed by : <a href="#">Mihir Vaghela</a>
                </p>
                <p class="text-right mt-1 mb-0">
                    Already have an account? <a href="index.php">Login</a>
                </p>
            </form>
        </div>

        <script src="js/reg.js"></script>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
            crossorigin="anonymous"></script>
    </body>

</html>