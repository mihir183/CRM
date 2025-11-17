<?php include 'check_session.php'; ?>
<?php include 'db.php'; ?>

<?php
// Fetch all tickets
$tickets = [];
if ($conn) {
  $stmt = $conn->prepare("SELECT * FROM tickets ORDER BY t_id DESC");
  $stmt->execute();
  $result = $stmt->get_result();

  while ($row = $result->fetch_assoc()) {
    $tickets[] = $row;
  }
  $stmt->close();
}
?>

<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ticket Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>

  <body>

    <?php include 'header.php'; ?>

    <div class="container mt-5">

      <div class="d-flex justify-content-between align-items-center">
        <h4 class="text-primary text-capitalize">
          <i class="fa-solid fa-ticket"></i> Ticket Register
        </h4>

        <a href="add_ticket.php" class="btn btn-primary text-capitalize">
          <i class="fa-solid fa-plus"></i> Add Ticket
        </a>
      </div>

      <hr>

      <table class="table table-bordered table-striped mt-3">
        <thead class="table-primary">
          <tr class="text-center">
            <th>ID</th>
            <th>Client</th>
            <th>Product</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
          <?php if (count($tickets) > 0): ?>
            <?php foreach ($tickets as $t): ?>
              <tr class="text-center">

                <td><?= $t['t_id']; ?></td>
                <td><?= $t['ticket_client']; ?></td>
                <td><?= $t['product']; ?></td>

                <td>
                  <div class="btn-group">
                    <button class="btn btn-info">view</button>
                    <a href="update_ticket.php?t_id=<?= $t['t_id']; ?>" class="btn btn-warning">
                      Edit
                    </a>
                  </div>
                </td>

              </tr>
            <?php endforeach; ?>

          <?php else: ?>

            <tr>
              <td colspan="10" class="text-center text-danger">
                No tickets found.
              </td>
            </tr>

          <?php endif; ?>
        </tbody>
      </table>

    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

  </body>

</html>