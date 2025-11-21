<?php require 'check_session.php'; ?>
<?php require 'autoExpire_session.php'; ?>
<?php include 'db.php'; ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Add Product</title>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-5">

    <h4 class="text-primary">Add Product</h4>
    <hr>

    <form action="save_product.php" method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label>Product Name *</label>
            <input type="text" name="p_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Variant *</label>
            <input type="text" name="variant" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Product Key *</label>
            <input type="text" name="product_key" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Licence Key *</label>
            <input type="text" name="licence_key" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Select File *</label>
            <input type="file" name="p_file" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Add Product</button>
        <a href="product.php" class="btn btn-secondary">Cancel</a>

    </form>

</div>

<?php include 'footer.php'; ?>

</body>
</html>
