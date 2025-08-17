<?php include 'check_session.php'; ?>
<?php
include 'db.php';

// Pagination settings
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Count total records
$totalStmt = $conn->prepare("SELECT COUNT(*) as total FROM client");
$totalStmt->execute();
$totalResult = $totalStmt->get_result();
$totalRow = $totalResult->fetch_assoc();
$totalClients = $totalRow['total'];
$totalPages = ceil($totalClients / $limit);

// Fetch paginated data
$stmt = $conn->prepare("SELECT * FROM client LIMIT ?, ?");
$stmt->bind_param("ii", $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

$clients = [];
while ($row = $result->fetch_assoc()) {
  $clients[] = $row;
}

$stmt->close();
?>

<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <title>Client</title>
  </head>

  <body>
    <!-- Header Start -->
    <?php include 'header.php'; ?>

    <!-- Successs Alert -->
    <?php if (!empty($_SESSION['success'])): ?>
      <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        <strong>Yeah</strong> <?= $_SESSION['success']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <div class="container pt-2">
      <p class="text-capitalized ms-3 fs-6 mb-4"><span class="text-primary"><i class="fa-solid fa-home">
          </i> home</span> / <i class="fa-solid fa-user"></i> client master</p>
      <div class="d-flex justify-content-between">
        <h4 class="text-primary text-capitalize"><i class="fa-solid fa-user"></i> client master </h4>
        <a href="add_client.php">
          <button class="btn btn-primary text-capitalize"><i class="fa-solid fa-user"></i> add client master</button>
        </a>
      </div>

    </div>

    <div class="container mt-3">
      <h5 class="text-primary">Client List</h5>
      <!-- Pagging Setting
      <div class="mt-3">
        <nav>
          <ul class="pagination justify-content-start">
            <?php if ($page > 1): ?>
              <li class="page-item">
                <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
              </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
              <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
              <li class="page-item">
                <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
              </li>
            <?php endif; ?>
          </ul>
        </nav>
      </div> -->
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
          <thead class="table-dark text-capitalize">
            <tr>
              <th>Company name</th>
              <th>Country</th>
              <th>registred mobile</th>
              <th>city</th>
              <th>Email</th>
              <th>isActive</th>
              <th>action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($clients) > 0): ?>
              <?php foreach ($clients as $index => $client): ?>
                <tr>
                  <!-- <td><?= $index + 1 ?></td> -->
                  <td><?= htmlspecialchars($client['company_name']) ?></td>
                  <td><?= htmlspecialchars($client['country']) ?></td>
                  <td><?= htmlspecialchars($client['mobile']) ?></td>
                  <td><?= htmlspecialchars($client['city']) ?></td>
                  <td><?= htmlspecialchars($client['email']) ?></td>
                  <td><?= htmlspecialchars($client['pin']) ?></td>
                  <td><a href="edit_client.php?id=<?php echo $client['cid']; ?>">
                      <button class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                    </a></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="10" class="text-center">No clients found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Pagging Setting -->
      <div class="mt-3">
        <nav>
          <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
              <li class="page-item">
                <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
              </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
              <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
              <li class="page-item">
                <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
              </li>
            <?php endif; ?>
          </ul>
        </nav>
      </div>

    </div>


    <!-- Footer Start -->
    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
      crossorigin="anonymous"></script>
  </body>

</html>