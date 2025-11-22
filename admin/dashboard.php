<?php
require '../pages/db.php';

$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM client");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$totalUsers = $row['total'];

$stmt = $conn->prepare("SELECT COUNT(*) AS tot_ticket FROM tickets");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$totalTickets = $row['tot_ticket'];

// Completed ticket
$stmt = $conn->prepare("SELECT COUNT(*) AS tot_complete FROM tickets WHERE status='completed'");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$totalCompleted = $row['tot_complete'];

// Count pending tickets
$stmt = $conn->prepare("SELECT COUNT(*) AS tot_pending FROM tickets WHERE status='pending'");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$totalPending = $row['tot_pending'];

// Fetch 5 recent tickets
$tickets = [];
$ticketStmt = $conn->prepare("SELECT * FROM tickets ORDER BY t_id DESC LIMIT 5");
$ticketStmt->execute();
$ticketResult = $ticketStmt->get_result();

while ($row = $ticketResult->fetch_assoc()) {
  $tickets[] = $row;
}
$ticketStmt->close();

// Fetch 5 recent clients
$clients = [];
$clientStmt = $conn->prepare("SELECT * FROM client ORDER BY cid DESC LIMIT 5");
$clientStmt->execute();
$clientResult = $clientStmt->get_result();

while ($row = $clientResult->fetch_assoc()) {
  $clients[] = $row;
}
$clientStmt->close();

?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM Dashboard</title>
  </head>

  <body>

    <!-- Loader -->
    <!-- <div id="loader"><div class="spinner-border"></div></div> -->

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Navbar -->
    <?php require 'header.php' ?>

    <!-- Main content -->
    <main class="container-fluid">
      <!-- Stats -->
      <div class="row g-3 mb-4 text-capitalize">
        <div class="col-6 col-md-3">
          <div class="card stat-card stat1">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <div>total users</div>
                  <h3 id="statTotal"><?php echo $totalUsers ?></h3>
                </div>
                <i class="fa-solid fa-users fa-2x opacity-75"></i>
              </div>
              <div class="mt-2 small">+12% from last week</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="card stat-card stat3">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <div>total tickets</div>
                  <h3 id="statPending"><?PHP echo $totalTickets?></h3>
                </div>
                <i class="fas fa-clock fa-2x opacity-75"></i>
              </div>
              <div class="mt-2 small">10% of total tickets</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="card stat-card stat2">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <div>Resolved</div>
                  <h3 id="statResolved"><?php echo $totalCompleted ?></h3>
                </div>
                <i class="fas fa-check-circle fa-2x opacity-75"></i>
              </div>
              <div class="mt-2 small">80% resolution rate</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="card stat-card stat4">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <div class="text-capitalize">pending</div>
                  <h3 id="statOverdue"><?PHP echo $totalPending?></h3>
                </div>
                <i class="fas fa-exclamation-triangle fa-2x opacity-75"></i>
              </div>
              <div class="mt-2 small">Needs immediate attention</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Data Cards -->
      <div class="row g-3 mb-4">
        <div class="col-md-6">
          <div class="card shadow-sm h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
              <span>Tickets Overview</span>
              <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-between mb-3">
                <div class="d-flex align-items-center">
                  <div class="bg-success rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                  <small>Resolved: 280 (80%)</small>
                </div>
                <div class="d-flex align-items-center">
                  <div class="bg-warning rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                  <small>Pending: 35 (10%)</small>
                </div>
                <div class="d-flex align-items-center">
                  <div class="bg-danger rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                  <small>Overdue: 35 (10%)</small>
                </div>
              </div>
              <div class="progress mb-4" style="height: 20px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 80%" aria-valuenow="80"
                  aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-warning" role="progressbar" style="width: 10%" aria-valuenow="10"
                  aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-danger" role="progressbar" style="width: 10%" aria-valuenow="10"
                  aria-valuemin="0" aria-valuemax="100"></div>
              </div>

              <div class="bg-light p-3 rounded dark:bg-dark">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="fw-medium">Average Resolution Time</span>
                  <span class="badge bg-info">18.5 hours</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <span class="fw-medium">First Response Time</span>
                  <span class="badge bg-primary">2.3 hours</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card shadow-sm h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
              <span>Requests Trend</span>
              <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
              <div class="row text-center mb-4">
                <div class="col-4">
                  <div class="fw-bold text-primary">42</div>
                  <small class="text-muted">This Week</small>
                </div>
                <div class="col-4">
                  <div class="fw-bold text-success">+15%</div>
                  <small class="text-muted">Change</small>
                </div>
                <div class="col-4">
                  <div class="fw-bold">158</div>
                  <small class="text-muted">This Month</small>
                </div>
              </div>

              <div class="bg-light p-3 rounded dark:bg-dark">
                <div class="d-flex justify-content-between mb-2">
                  <span>Mon</span>
                  <span>Tue</span>
                  <span>Wed</span>
                  <span>Thu</span>
                  <span>Fri</span>
                  <span>Sat</span>
                  <span>Sun</span>
                </div>
                <div class="d-flex justify-content-between align-items-end" style="height: 40px;">
                  <div class="bg-primary rounded" style="width: 12%; height: 30%;"></div>
                  <div class="bg-primary rounded" style="width: 12%; height: 50%;"></div>
                  <div class="bg-primary rounded" style="width: 12%; height: 70%;"></div>
                  <div class="bg-primary rounded" style="width: 12%; height: 100%;"></div>
                  <div class="bg-primary rounded" style="width: 12%; height: 80%;"></div>
                  <div class="bg-primary rounded" style="width: 12%; height: 40%;"></div>
                  <div class="bg-primary rounded" style="width: 12%; height: 60%;"></div>
                </div>
              </div>

              <div class="mt-3 d-flex justify-content-between">
                <div>
                  <span class="badge bg-success">Completed: 125</span>
                </div>
                <div>
                  <span class="badge bg-warning">In Progress: 22</span>
                </div>
                <div>
                  <span class="badge bg-info">New: 11</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Tables -->
      <div class="row g-3 mb-5">
        <div class="col-md-6">
          <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
              <span>Recent Tickets</span>
              <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
              <div class="table-container">
                <table class="table table-hover">
                  <thead class="table-light">
                    <tr>
                      <th>ID</th>
                      <th>client name</th>
                      <th>Status</th>
                      <th>Agent</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($tickets as $t): ?>
                      <tr>
                        <td class="fw-bold">#<?= $t['t_id'] ?></td>
                        <td><?= $t['ticket_client'] ?></td>
                        <td><span class="badge bg-info"><?= $t['status'] ?></span></td>
                        <td><?= $t['given_by'] ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>

                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
              <span class="text-capitalize">recent costomer</span>
              <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
              <div class="table-container">
                <table class="table table-hover text-capitalize">
                  <thead class="table-light">
                    <tr>
                      <th>ID</th>
                      <th>costomer</th>
                      <th>company</th>
                      <th>mobile</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($clients as $c): ?>
                      <tr>
                        <td class="fw-bold">#<?= $c['cid'] ?></td>
                        <td><?= $c['key_person'] ?></td>
                        <td><?= $c['company_name'] ?></td>
                        <td><?= $c['mobile'] ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>

                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <?php require 'footer.php'?>

    
  </body>

</html>