<?php
require 'db.php';

// fetch products
$products = [];
if($conn){
    $stmt = $conn->prepare("SELECT * FROM products ORDER BY p_id DESC");
    $stmt->execute();
    $result = $stmt->get_result();

    while($row = $result->fetch_assoc()){
        $products[] = $row;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>

    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<!-- Header -->
<div class="overlay" id="overlay"></div>
<?php require 'header.php'?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-primary">Products</h3>

        <a href="add_product.php" class="btn btn-primary">
            + Add Product
        </a>
    </div>

    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th width="60">ID</th>
                <th>Product Name</th>
                <th>download</th>
                <th width="160">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($products) > 0){ ?>
                <?php foreach($products as $p){ ?>
                    <tr>
                        <td><?= $p['p_id']?></td>
                        <td><?= $p['p_name']?></td>
                        <td><?= $p['p_path']?></td>
                        <td>
                            <a href="edit_product.php?id=<?= $p['p_id']?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="delete_product.php?id=<?= $p['p_id']?>" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="4" class="text-center">No Product Found</td>
                </tr>
            <?php } ?>
        </tbody>

    </table>

</div>


<!-- footer -->
<?php require 'footer.php'?>

</body>
</html>
