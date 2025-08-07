<?php include 'check_session.php' ?>

<?php
include 'db.php';

$client = [];

if ($conn) {
  $stmt = $conn->prepare("SELECT * FROM client");
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_assoc()) {
    $clients[] = $row;
  }
  $stmt->close();
}
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


    <div class="container pt-2">

      <p class="text-capitalized ms-3 fs-6 mb-4"><span class="text-primary"><i class="fa-solid fa-home"></i> home</span>
        / <i class="fa-solid fa-user"></i> clent master</p>

      <div class="d-flex justify-content-between">
        <h4 class="text-primary text-capitalize"><i class="fa-solid fa-user"></i> client master </h4>
        <a href="add_client.php">
          <button class="btn btn-primary text-capitalize"><i class="fa-solid fa-user"></i> add client master</button>
        </a>
      </div>

    </div>

    <div class="container mt-5">
      <h5 class="text-primary">Client List</h5>
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
                  <td><button class="btn btn-primary"></button></td>
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
    </div>


    <!-- Footer Start -->
    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
      crossorigin="anonymous"></script>
  </body>

</html>