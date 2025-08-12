<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Header Page</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
            integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="icon" href="assets/images/logo.png" type="image/png">
        <link rel="stylesheet" href="assets/css/header.css">
    </head>

    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand d-flex gap-2" href="home.php">
                    <img src="assets/images/MNE.png" class="rounded rounded-1" alt="" width="40">
                    <h2 class="text-capitalize text-light">user</h2>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <!-- Home Link -->
                        <li class="nav-item">
                            <a class="nav-link active d-flex gap-1 justify-content-center align-items-center text-light text-capitalize"
                                aria-current="page" href="home.php">
                                <i class="fa-solid fa-house-chimney"></i>home
                            </a>
                        </li>

                        <!-- Correct Dropdown -->
                        <li class="nav-item">
                            <button type="button" class="nav-link btn bg-transparent text-capitalize border-0 text-light m-0" data-bs-toggle="modal"
                                data-bs-target="#exampleModal1">
                                <i class="fa-solid fa-user"></i> client <i class="fa-solid fa-angle-down"></i>
                            </button>
                        </li>

                        <!-- Ticket Register Link -->
                        <li class="nav-item">
                            <a class="nav-link active d-flex gap-1 justify-content-center align-items-center text-light text-capitalize"
                                aria-current="page" href="ticket_register.php">
                                <i class="fa-solid fa-ticket"></i>ticket register
                            </a>
                        </li>

                        <!-- Sign Out -->
                        <li class="nav-item">
                            <a class="nav-link active d-flex gap-1 justify-content-center align-items-center text-light text-capitalize"
                                aria-current="page" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fa-solid fa-right-from-bracket"></i>Sign Out
                            </a>
                        </li>
                    </ul>

                    <h4 class="text-light text-capitalize mb-0"><?php echo "Hello, " . $_SESSION['user'] ?></h4>
                </div>
            </div>
        </nav>

        <!-- Button trigger modal -->


        <!-- Modal -->
        <div class="CModal modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog w-25 m-0">
                <div class="modal-content m-0">
                    <div class="modal-body d-flex flex-column gap-1">
                        <a href="client.php" class="text-capitalize text-decoration-none text-black">
                            <i class="fa-solid fa-user"></i> client
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for SignOut -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Sign Out</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to sign out?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <a href="logout.php" class="btn btn-danger">Confirm</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal for SignOut -->

        <!-- Bootstrap Bundle JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
            crossorigin="anonymous"></script>
    </body>

</html>