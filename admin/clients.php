<?php
include 'db.php';

// fetch clients
$clients = [];

if ($conn) {
    $stmt = $conn->prepare("SELECT * FROM client ORDER BY cid DESC");
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $clients[] = $row;
    }

    $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Clients</title>

        <!-- Sweet Alert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>

    <body>

        <!-- Header -->
        <div class="overlay" id="overlay"></div>
        <?php require 'header.php'; ?>

        <div class="container">
            <h2 style="text-align:center;margin-top:20px;">
                All Clients
            </h2>

            <table class="table border-1 mb-5">
                <tr>
                    <th>ID</th>
                    <th>Client Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>

                <?php if (count($clients) > 0): ?>
                    <?php foreach ($clients as $c): ?>
                        <tr>
                            <td><?= $c['cid'] ?></td>
                            <td><?= $c['key_person'] ?></td>
                            <td><?= $c['product'] ?></td>
                            <td><?= $c['mobile'] ?></td>
                            <td>
                                <a href="edit_client.php?id=<?= $c['cid'] ?>" class="btn btn-warning">EDIT</a>

                                <a href="#" onclick="deleteClient(<?= $c['cid'] ?>)" class="btn btn-danger">DELETE</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No Clients Found</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>

        <script>
            function deleteClient(id) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "This will delete permanently",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes delete it!"
                }).then((r) => {
                    if (r.isConfirmed) {
                        window.location = "delete_client.php?id=" + id;
                    }
                })
            }
        </script>

        <!-- alert -->
        <?php if (isset($_SESSION['success'])): ?>
            <script>
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "<?= $_SESSION['success'] ?>"
                });
            </script>
            <?php unset($_SESSION['success']); endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "<?= $_SESSION['error'] ?>"
                });
            </script>
            <?php unset($_SESSION['error']); endif; ?>

        <!-- Footer -->
        <?php require 'footer.php'; ?>

    </body>

</html>