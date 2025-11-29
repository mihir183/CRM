<?php
include 'check_session.php';
include 'autoExpire_session.php';
include 'db.php';

// Fetch Products from DB
$products = mysqli_query($conn, "SELECT p_id, p_name FROM products ORDER BY p_name ASC");
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Add Client</title>
  <link rel="short icon" href="../assets/images/MNE.png" />
</head>

<body>

  <?php include 'header.php'; ?>

  <!-- Success Alert -->
  <?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
      <strong>Yeah</strong> <?= $_SESSION['success']; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>

  <!-- Error Alert -->
  <?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-warning alert-dismissible fade show m-3" role="alert">
      <strong>Oops!</strong> <?= $_SESSION['error']; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['error']); ?>
  <?php endif; ?>

  <div class="container mt-2">
    <div class="container mt-5 d-flex justify-content-between">
      <h4 class="text-primary text-capitalize text-start"><i class="fa-solid fa-user"></i> add client</h4>
      <a href="client.php">
        <button class="btn btn-primary">&lt; back</button>
      </a>
    </div>

    <p class="text-danger">* Denotes compulsory fields & special symbols like &lt;&gt; " ' \ etc are not allowed</p>

    <form action="insert_client.php" id="myForm" method="post">
      <!-- ROW 1 -->
      <div class="row mb-3">
        <div class="col">
          <label for="company">Company Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="company" id="company" placeholder="COMPANY NAME" autofocus required>
        </div>
        <div class="col">
          <label for="city">City <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="city" id="city" placeholder="City" required>
        </div>
        <div class="col">
          <label for="country">Country <span class="text-danger">*</span></label>
          <select name="country" id="country" class="form-control" required>
            <option disabled selected>--Select Country--</option>
            <option value="India">India</option>
            <option value="US">US</option>
            <option value="Russia">Russia</option>
          </select>
        </div>
      </div>

      <!-- ROW 2 -->
      <div class="row mb-3">
        <div class="col">
          <label for="mobile">Registered Mobile <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="mobile" id="mobile" maxlength="10"
                 oninput="this.value = this.value.replace(/[^0-9]/g,'').slice(0,10);" required>
        </div>
        <div class="col">
          <label for="address">Address <span class="text-danger">*</span></label>
          <textarea class="form-control" name="address" id="address" required></textarea>
        </div>
        <div class="col">
          <label for="email">Email Address <span class="text-danger">*</span></label>
          <input type="email" class="form-control" name="email" id="email" required>
        </div>
      </div>

      <!-- ROW 3 -->
      <div class="row mb-3">
        <div class="col">
          <label for="key">Key Person <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="key" id="key" required>
        </div>
        <div class="col">
          <label for="phone">Phone</label>
          <input type="text" class="form-control" name="phone" id="phone" maxlength="10"
                 oninput="this.value = this.value.replace(/[^0-9]/g,'').slice(0,10);">
        </div>
        <div class="col">
          <label for="pin">Pin</label>
          <input type="text" class="form-control" name="pin" id="pin">
        </div>
      </div>

      <!-- ROW 4: PRODUCT -->
      <div class="row mb-3">
        <div class="col">
          <label for="product">Product <span class="text-danger">*</span></label>
          <select name="product" id="product" class="form-control" required>
            <option disabled selected>-- Select Product --</option>
            <?php while ($row = mysqli_fetch_assoc($products)): ?>
              <option value="<?= $row['p_name'] ?>"><?= htmlspecialchars($row['p_name']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="col">
          <label for="variant">Variant <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="variant" id="variant" placeholder="Variant" readonly required>
        </div>
        <div class="col">
          <label for="p_key">Product Key <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="p_key" id="p_key" placeholder="Product Key" readonly required>
        </div>
      </div>

      <!-- ROW 5 -->
      <div class="row mb-3">
        <div class="col col-4">
          <label for="l_key">License Key <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="l_key" id="l_key" placeholder="Licence_key" readonly required>
        </div>
      </div>

      <div class="row mb-5 flex-row-reverse">
        <div class="col col-4">
          <button type="submit" class="btn btn-primary w-100">Add</button>
        </div>
      </div>
    </form>
  </div>

  <?php include 'footer.php'; ?>

  <!-- AJAX to fetch product details -->
  <script>
    document.getElementById('product').addEventListener('change', function() {
      let p_name = this.value;

      if (!p_name) {
        document.getElementById('variant').value = '';
        document.getElementById('p_key').value = '';
        document.getElementById('l_key').value = '';
        return;
      }

      fetch('get_product_data.php?p_name=' + encodeURIComponent(p_name))
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            document.getElementById('variant').value = data.data.variant;
            document.getElementById('p_key').value = data.data.product_key;
            document.getElementById('l_key').value = data.data.licence_key;
          } else {
            document.getElementById('variant').value = '';
            document.getElementById('p_key').value = '';
            document.getElementById('l_key').value = '';
          }
        })
        .catch(err => console.error(err));
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
