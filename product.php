<?php require 'check_session.php'; ?>
<?php require 'autoExpire_session.php'; ?>
<?php include 'db.php'; ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Products</title>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-5">

    <div class="d-flex justify-content-between">
        <h4 class="text-primary">Product List</h4>

        <a href="add_product.php" class="btn btn-primary">
            + Add Product
        </a>
    </div>

    <hr>

    <table class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th>Sr No</th>
                <th>Product Name</th>
                <th>Download</th>
            </tr>
        </thead>

        <tbody>

        <?php
        $sr = 1;
        $result = $conn->query("SELECT * FROM products ORDER BY p_id DESC");

        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
        ?>
            <tr class="text-center">
                <td><?= $sr++; ?></td>
                <td><?= $row['p_name']; ?></td>
                <td>
                    <a href="uploads/products/<?= $row['p_path']; ?>" download>
                        <?= $row['p_path']; ?>
                    </a>
                </td>
            </tr>

        <?php endwhile; else: ?>

            <tr>
                <td colspan="3" class="text-center text-danger">
                    No products found.
                </td>
            </tr>

        <?php endif; ?>

        </tbody>
    </table>

</div>

<?php include 'footer.php'; ?>

</body>
</html>
