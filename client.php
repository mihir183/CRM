<?php include 'check_session.php'?>
<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <title>Home</title>
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
      <table class="table">
      <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td>John</td>
            <td>Doe</td>
            <td>@social</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Footer Start -->
    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
      crossorigin="anonymous"></script>
  </body>

</html>