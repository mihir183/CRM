<?php include 'check_session.php'; ?>
<?php include 'autoExpire_session.php'; ?>
<?php
include 'db.php';

// ----------------------
// FETCH CLIENT LIST
// ----------------------
$clients = [];
if ($conn) {
    $stmt = $conn->prepare("SELECT * FROM client");
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $clients[] = $row;
    }
    $stmt->close();
}

// ----------------------
// FETCH LOGGED IN USER DETAILS
// ----------------------
$user_name = "";
$user_mobile = "";

if (isset($_SESSION['user'])) {
    $username = $_SESSION['user'];

    // Fetch user details using username
    $stmt = $conn->prepare("SELECT username, phone FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $user_name = $row['username'];
        $user_mobile = $row['phone'];
    }

    $stmt->close();
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
    <?php include 'header.php' ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-warning alert-dismissible fade show m-3" role="alert">
            <strong>Oops!</strong> <?= $_SESSION['error']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="container mt-5 d-flex justify-content-between">
        <h4 class="text-primary text-capitalize text-start"><i class="fa-solid fa-ticket"></i> add ticket register</h4>
        <a href="ticket_register.php" class="">
            <button class="btn btn-primary text-right">< back</button>
        </a>
    </div>

    <div class="container mt-3 mb-5">
        <p class="text-danger">* Denotes compulsory fields & special symbol like <> " ' \ etc is not allowed due to security reason</p>

        <form action="insert_ticket.php" method="POST" enctype="multipart/form-data">
            <div class="row row-cols-2">

                <!-- LEFT COLUMN -->
                <div class="col">
                    <label for="date" class="form-label text-capitalize">date<span class="text-danger">*</span></label>
                    <input type="date" id="date" name="date" required class="form-control mb-2">

                    <label for="client" class="form-label text-capitalize">client<span class="text-danger">*</span></label>
                    <select name="ticket_client" id="client" class="form-control mb-5">
                        <option value="">Select Client</option>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?= htmlspecialchars($client['key_person']) ?>"><?= $client['key_person'] ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="product" class="form-label text-capitalize">product<span class="text-danger">*</span></label>
                    <input name="product" id="product" class="form-control">

                    <label for="complain" class="form-label text-capitalize">complain<span class="text-danger">*</span></label>
                    <textarea name="complain" id="complain" class="form-control"></textarea>
                </div>

                <!-- RIGHT COLUMN -->
                <div class="col">
                    <div class="row row-cols-2 mb-1">
                        <div class="col">
                            <label for="client_name" class="form-label text-capitalize">name</label>
                            <input type="text" id="client_name" name="client_name" class="form-control mb-2" readonly>
                        </div>
                        <div class="col">
                            <label for="client_mobile" class="form-label text-capitalize">registered mobile</label>
                            <input type="text" id="client_mobile" name="client_mobile" class="form-control mb-2" readonly>
                        </div>
                    </div>

                    <label for="address" class="form-label text-capitalize">address</label>
                    <textarea name="address" id="address" class="form-control" readonly></textarea>

                    <div class="row row-cols-2 mb-1 mt-2">
                        <div class="col">
                            <label for="city" class="form-label text-capitalize">city</label>
                            <input type="text" id="city" name="city" class="form-control mb-2" readonly>
                        </div>
                        <div class="col">
                            <label for="email" class="form-label text-capitalize">email</label>
                            <input type="text" id="email" name="email" class="form-control mb-2" readonly>
                        </div>
                    </div>

                    <label for="exdate" class="form-label text-capitalize">expired date</label>
                    <input type="text" id="exdate" name="exdate" class="form-control mb-2" readonly>

                    <div class="row row-cols-2 mb-1">
                        <div class="col">
                            <label for="ctype" class="form-label text-capitalize">call type</label>
                            <select name="ctype" id="ctype" class="form-select mb-2">
                                <option selected disabled>-- select call type --</option>
                                <option value="Offline">Offline</option>
                                <option value="Online">Online</option>
                            </select>   
                        </div>
                        <div class="col">
                            <label for="serial" class="form-label text-capitalize">serial number</label>
                            <input type="text" id="serial" name="serial_number" class="form-control mb-2">
                        </div>
                    </div>

                </div>
            </div>

            <div class="mb-3">
                <label class="form-label text-capitalize">special remark</label>
                <input type="text" name="remark" class="form-control">
            </div>

            <div class="row row-cols-3 mb-4">
                <div class="col"><label>select image1</label><input type="file" name="img1"></div>
                <div class="col"><label>select image2</label><input type="file" name="img2"></div>
                <div class="col"><label>select image3</label><input type="file" name="img3"></div>
            </div>

            <!-- AUTO-FILLED FROM USERS TABLE -->
            <div class="row row-cols-2 mb-4">
                <div class="col">
                    <label for="given" class="form-label text-capitalize">given by<span class="text-danger">*</span></label>
                    <input type="text" name="given_by" id="given" class="form-control"
                        value="<?= htmlspecialchars($user_name) ?>" readonly required>
                </div>
                <div class="col">
                    <label for="mobile" class="form-label text-capitalize">mobile number<span class="text-danger">*</span></label>
                    <input type="text" name="mobile" id="mobile" class="form-control"
                        value="<?= htmlspecialchars($user_mobile) ?>" readonly required>
                </div>
            </div>

            <div class="row justify-content-end">
                <div class="col-4">
                    <button class="btn btn-primary mb-5 w-100">save</button>
                </div>
                <div class="col-4">
                    <a href="ticket_register.php">
                        <button type="button" class="btn btn-primary mb-5 w-100">cancel</button>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- AJAX CLIENT DATA -->
    <script>
        document.getElementById('client').addEventListener('change', function () {
            const keyPerson = this.value;

            const fields = ["client_name", "client_mobile", "address", "city", "email", "product"];

            if (!keyPerson) {
                fields.forEach(id => document.getElementById(id).value = "");
                return;
            }

            fetch('get_client_data.php?key_person=' + encodeURIComponent(keyPerson))
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('client_name').value = data.client.key_person || '';
                        document.getElementById('client_mobile').value = data.client.mobile || '';
                        document.getElementById('address').value = data.client.address || '';
                        document.getElementById('city').value = data.client.city || '';
                        document.getElementById('email').value = data.client.email || '';
                        document.getElementById('product').value = data.client.product || '';
                        document.getElementById('exdate').value = data.client.expire_d || '';
                    } else {
                        fields.forEach(id => document.getElementById(id).value = "");
                        alert("Client not found!");
                    }
                })
                .catch(() => fields.forEach(id => document.getElementById(id).value = ""));
        });
    </script>

    <?php include 'footer.php' ?>
</body>

</html>
