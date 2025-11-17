<?php 
include 'check_session.php';
include 'db.php';

if (!isset($_GET['t_id'])) {
    die("Invalid Ticket ID");
}

$t_id = $_GET['t_id'];

// Fetch ticket details
$stmt = $conn->prepare("SELECT * FROM tickets WHERE t_id = ?");
$stmt->bind_param("i", $t_id);
$stmt->execute();
$result = $stmt->get_result();
$ticket = $result->fetch_assoc();

if (!$ticket) {
    die("Ticket not found");
}

// Upload image function
function uploadImage($key)
{
    if (!isset($_FILES[$key]) || $_FILES[$key]['error'] != 0) return "";

    $allowed = ['jpg','jpeg','png','gif','pdf'];
    $ext = strtolower(pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) return "";

    $newName = time() . "_" . uniqid() . "." . $ext;
    $path = "uploads/tickets/";

    if (!is_dir($path)) mkdir($path, 0777, true);

    move_uploaded_file($_FILES[$key]['tmp_name'], $path . $newName);

    return $newName;
}

// Handle form submit
if (isset($_POST['update'])) {

    $ticket_client = trim($_POST['ticket_client']);
    $product = trim($_POST['product']);
    $complain = trim($_POST['complain']);
    $status = trim($_POST['status']);

    // Upload new images (optional)
    $img1 = uploadImage('img1');
    $img2 = uploadImage('img2');
    $img3 = uploadImage('img3');

    // If no new image uploaded → keep old
    if ($img1 == "") $img1 = $ticket['img1'];
    if ($img2 == "") $img2 = $ticket['img2'];
    if ($img3 == "") $img3 = $ticket['img3'];

    $up = $conn->prepare("UPDATE tickets SET 
        ticket_client=?, 
        product=?, 
        complain=?, 
        status=?, 
        img1=?, 
        img2=?, 
        img3=? 
        WHERE t_id=?");

    $up->bind_param(
        "sssssssi",
        $ticket_client,
        $product,
        $complain,
        $status,
        $img1,
        $img2,
        $img3,
        $t_id
    );

    if ($up->execute()) {
        header("Location: ticket_register.php");
        exit;
    } else {
        echo "Update Failed: " . $up->error;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Update Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'header.php'?>

<div class="container mt-5">
    <h3 class="text-primary">Update Ticket</h3>
    <hr>

    <form method="POST" enctype="multipart/form-data" class=" mb-5">

        <div class="mb-3">
            <label>Client *</label>
            <input type="text" name="ticket_client" class="form-control" value="<?= $ticket['ticket_client'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Product *</label>
            <input type="text" name="product" class="form-control" value="<?= $ticket['product'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Complain *</label>
            <textarea name="complain" class="form-control" required><?= $ticket['complain'] ?></textarea>
        </div>

        <!-- Status Dropdown -->
        <div class="mb-3">
            <label>Status *</label>
            <select name="status" class="form-control" required>
                <option value="Pending" <?= ($ticket['status']=="Pending"?"selected":"") ?>>Pending</option>
                <option value="In-Process" <?= ($ticket['status']=="In-Process"?"selected":"") ?>>In-Process</option>
                <option value="Completed" <?= ($ticket['status']=="Completed"?"selected":"") ?>>Completed</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Image 1</label>
            <input type="file" name="img1" class="form-control">
            <small>Current: <?= $ticket['img1'] ?></small>
        </div>

        <div class="mb-3">
            <label>Image 2</label>
            <input type="file" name="img2" class="form-control">
            <small>Current: <?= $ticket['img2'] ?></small>
        </div>

        <div class="mb-3">
            <label>Image 3</label>
            <input type="file" name="img3" class="form-control">
            <small>Current: <?= $ticket['img3'] ?></small>
        </div>

        <button type="submit" name="update" class="btn btn-success">Update Ticket</button>
        <a href="ticket_register.php" class="btn btn-secondary">Cancel</a>

    </form>
</div>

<?php include 'footer.php'?>

</body>
</html>
