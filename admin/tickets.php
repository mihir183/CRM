<?php
include 'db.php'; // your DB connection

// Get selected status from GET (for filter)
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';

// fetch tickets
$tickets = [];
if ($conn) {
    if ($statusFilter) {
        $stmt = $conn->prepare("SELECT * FROM tickets WHERE status = ? ORDER BY t_id DESC");
        $stmt->bind_param("s", $statusFilter);
    } else {
        $stmt = $conn->prepare("SELECT * FROM tickets ORDER BY t_id DESC");
    }
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $tickets[] = $row;
    }
    $stmt->close();
}

// possible status options
$statusOptions = ['Completed', 'Pending', 'Overdue', 'In Progress', 'In Review'];
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tickets</title>

        <!-- Sweet Alert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <style>
            table {
                width: 90%;
                margin: auto;
                border-collapse: collapse;
                margin-top: 20px;
            }

            th,
            td {
                border: 1px solid black;
                padding: 10px;
                text-align: center;
            }

            th {
                background: #222;
                color: white;
            }

            a.btn {
                padding: 6px 10px;
                background: blue;
                color: white;
                text-decoration: none;
            }

            a.btn-del {
                background: red;
            }

            .filter-container {
                width: 90%;
                margin: 20px auto;
                display: flex;
                justify-content: flex-end;
                align-items: center;
            }

            .filter-container select {
                padding: 5px 10px;
            }
        </style>
    </head>

    <body>

        <div class="overlay" id="overlay"></div>

        <?php include 'header.php'; ?>

        <div class="filter-container">
            <form method="GET" action="">
                <label for="status">Filter by Status:</label>
                <select name="status" id="status" class="form-select" onchange="this.form.submit()">
                    <option value="">All</option>
                    <?php foreach ($statusOptions as $status): ?>
                        <option value="<?= $status ?>" <?= ($statusFilter === $status) ? 'selected' : '' ?>><?= $status ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>

        <div class="container">
            <h2 style="text-align:center;margin-top:20px;">All Tickets</h2>

            <table class="table mb-5 table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Client</th>
                        <th>Product</th>
                        <th>Complain</th>
                        <th>Serial</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (count($tickets) > 0): ?>
                        <?php foreach ($tickets as $t): ?>
                            <tr>
                                <td><?= $t['t_id'] ?></td>
                                <td><?= $t['date'] ?></td>
                                <td><?= $t['ticket_client'] ?></td>
                                <td><?= $t['product'] ?></td>
                                <td><?= $t['complain'] ?></td>
                                <td><?= $t['serial_number'] ?></td>
                                <td><?= $t['status'] ?></td>
                                <td>
                                    <a href="edit_ticket.php?id=<?= $t['t_id'] ?>" class="btn">EDIT</a>
                                    <a href="#" onclick="deleteTicket(<?= $t['t_id'] ?>)" class="btn btn-del">DELETE</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">No Tickets Found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Sweet delete confirm -->
        <script>
            function deleteTicket(id) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "This will delete ticket permanently",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes delete it!"
                }).then((r) => {
                    if (r.isConfirmed) {
                        window.location = "delete_ticket.php?id=" + id;
                    }
                });
            }
        </script>

        <!-- Sweet alert messages -->
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

        <?php include 'footer.php'; ?>

    </body>

</html>