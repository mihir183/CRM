<?php include 'check_session.php' ?>
<?php include 'autoExpire_session.php' ?>

<?php include 'db.php';

if ($conn) {

  if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM client WHERE cid = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $client = $result->fetch_assoc();

    if (!$client) {
      die("Client not found.");
    }
  } else {
    header("Location: client.php");
  }
}

?>
<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <title>Add Client</title>
  </head>

  <body>

    <?php include 'header.php'; ?>

    <!-- Successs Alert -->
    <?php if (!empty($_SESSION['success'])): ?>
      <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        <strong>Yeah</strong> <?= $_SESSION['success']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Error Alert -->
    <?php if (!empty($_SESSION['error'])): ?>
      <div class="alert alert-warning alert-dismissible fade show m-3" role="alert">
        <strong>Oops!</strong> <?= $_SESSION['error']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="container mt-2">
      <div class="container mt-5 mb-3 d-flex justify-content-between">
        <h4 class="text-primary text-capitalize text-start"><i class="fa-solid fa-user"></i> edit client
        </h4>
        <a href="client.php" class="">
          <button class="btn btn-primary text-right">
            < back</button>
        </a>
      </div>

      <form action="update_client.php" id="myForm" method="post">
        <!-- ROW 1 -->
        <div class="row mb-3">
          <div class="col">
            <label for="company" class="text-capitalize">
              company name<span class="text-danger form-label">*</span>
            </label>
            <input type="text" class="form-control" name="company" value="<?php echo $client['company_name']; ?>" id="company" placeholder="COMPANY NAME" autofocus>
          </div>

          <div class="col">
            <label for="city" class="text-capitalize">
              city<span class="text-danger form-label">*</span>
            </label>
            <input type="text" class="form-control" name="city" id="city" placeholder="City" value="<?php echo $client['city']; ?>" required>
          </div>

          <div class="col">
            <label for="country" class="text-capitalize">
              country<span class="text-danger form-label">*</span>
            </label>
            <select name="country" id="country" class="form-control" value="<?php echo $client['coutry']; ?>">
              <option>Select Country</option>
              <option value="India" selected>India</option>
              <option value="US">US</option>
              <option value="Russia">Russia</option>
            </select>
          </div>
        </div>
        <!-- ROW 2 -->
        <div class="row mb-3">
          <div class="col">
            <label for="mobile" class="text-capitalize">
              registered mobile<span class="text-danger form-label">*</span>
            </label>
            <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Registered Mobile"value="<?php echo $client['mobile']; ?>"
              maxlength="10" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10);">
            <p class="err text-danger small" id="err_mob"></p>
          </div>

          <div class="col">
            <label for="address" class="text-capitalize">
              address<span class="text-danger form-label">*</span>
            </label>
            <textarea type="text" class="form-control" name="address" id="address" placeholder="Address" required></textarea>
          </div>

          <div class="col">
            <label for="email" class="text-capitalize">
              Email Address<span class="text-danger form-label">*</span>
            </label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" value="<?php echo $client['email']; ?>" required>
          </div>
        </div>
        <!-- ROW 3 -->
        <div class="row mb-3">
          <div class="col">
            <label for="key" class="text-capitalize">
              Key Person<span class="text-danger form-label">*</span>
            </label>
            <input type="text" class="form-control" name="key" id="key" placeholder="Key Person" value="<?php echo $client['key_person']; ?>" required>
          </div>

          <div class="col">
            <label for="phone" class="text-capitalize">Phone</label>
            <input type="text" class="form-control" name="phone" id="phone" maxlength="10" placeholder="Phone" value="<?php echo $client['phone']; ?>"
              oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10);">
            <p class="err text-danger small" id="err_pho"></p>
          </div>

          <div class="col">
            <label for="pin" class="text-capitalize">Pin</label>
            <input type="text" class="form-control" name="pin" id="pin" placeholder="Pin" value="<?php echo $client['pin']; ?>">
          </div>
        </div>
        <!-- ROW 4 -->
        <div class="row mb-3">
          <div class="col">
            <label for="product" class="text-capitalize">
              product<span class="text-danger form-label">*</span>
            </label>
            <input type="text" class="form-control" name="product" id="product" placeholder="Product" value="<?php echo $client['product']; ?>" required>
          </div>

          <div class="col">
            <label for="variant" class="text-capitalize">
              variant<span class="text-danger form-label">*</span>
            </label>
            <input type="text" class="form-control" name="variant" id="variant" placeholder="Variant" value="<?php echo $client['variant']; ?>" required>
          </div>

          <div class="col">
            <label for="p_key" class="text-capitalize">
              product key<span class="text-danger form-label">*</span>
            </label>
            <input type="text" class="form-control" name="p_key" id="p_key" placeholder="Prodyct Key" value="<?php echo $client['p_key']; ?>" required>
          </div>
        </div>
        <!-- ROW 5 -->
        <div class="row mb-3 row-cols-1">
          <div class="col col-4">
            <label for="l_key" class="text-capitalize">
              license key<span class="text-danger form-label">*</span>
            </label>
            <input type="text" class="form-control" name="l_key" id="l_key" placeholder="License Key" value="<?php echo $client['l_key']; ?>" required>
          </div>
        </div>

        <div class="row mb-5 flex-row-reverse">
          <div class="col col-4">
            <button type="submit" class="btn btn-primary w-100 text-capitalize">update</button>
          </div>
        </div>
      </form>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
      crossorigin="anonymous"></script>
  </body>

</html>