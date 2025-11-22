<?php 
include 'check_session.php'; 
include 'db.php'; 

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
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
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
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>

    <tbody>
      <?php if(count($tickets) > 0): ?>
        <?php foreach($tickets as $t): ?>
          <tr class="text-center">
            <td><?= $t['t_id']; ?></td>
            <td><?= $t['ticket_client']; ?></td>
            <td><?= $t['product']; ?></td>
            <td><?= $t['status']; ?></td>
            <td>
              <div class="btn-group">
                <!-- View button triggers modal -->
                <button class="btn btn-info" 
                        data-bs-toggle="modal" 
                        data-bs-target="#viewTicketModal"
                        data-id="<?= $t['t_id']; ?>"
                        data-client="<?= $t['ticket_client']; ?>"
                        data-product="<?= $t['product']; ?>"
                        data-status="<?= $t['status']; ?>"
                        data-complain="<?= $t['complain']; ?>"
                        data-serial="<?= $t['serial_number']; ?>"
                        data-date="<?= $t['date']; ?>">
                  View
                </button>

                <a href="update_ticket.php?t_id=<?= $t['t_id']; ?>" class="btn btn-warning">Edit</a>
                <a href="delete_ticket.php?t_id=<?= $t['t_id']; ?>" class="btn btn-danger"
                   onclick="return confirm('Are you sure you want to delete this ticket?');">
                  Delete
                </a>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="10" class="text-center text-danger">No tickets found.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>

</div>

<!-- Modal -->
<div class="modal fade" id="viewTicketModal" tabindex="-1" aria-labelledby="viewTicketModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewTicketModalLabel">Ticket Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="list-group">
          <li class="list-group-item"><strong>ID:</strong> <span id="modal-tid"></span></li>
          <li class="list-group-item"><strong>Date:</strong> <span id="modal-date"></span></li>
          <li class="list-group-item"><strong>Client:</strong> <span id="modal-client"></span></li>
          <li class="list-group-item"><strong>Product:</strong> <span id="modal-product"></span></li>
          <li class="list-group-item"><strong>Status:</strong> <span id="modal-status"></span></li>
          <li class="list-group-item"><strong>Complain:</strong> <span id="modal-complain"></span></li>
          <li class="list-group-item"><strong>Serial Number:</strong> <span id="modal-serial"></span></li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Populate modal with ticket data
  var viewModal = document.getElementById('viewTicketModal');
  viewModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;

    document.getElementById('modal-tid').textContent = button.getAttribute('data-id');
    document.getElementById('modal-date').textContent = button.getAttribute('data-date');
    document.getElementById('modal-client').textContent = button.getAttribute('data-client');
    document.getElementById('modal-product').textContent = button.getAttribute('data-product');
    document.getElementById('modal-status').textContent = button.getAttribute('data-status');
    document.getElementById('modal-complain').textContent = button.getAttribute('data-complain');
    document.getElementById('modal-serial').textContent = button.getAttribute('data-serial');
  });
</script>

</body>
</html>
