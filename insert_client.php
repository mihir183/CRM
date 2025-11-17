<?php
include 'db.php';

if ($conn) {
    $company = trim($_POST['company'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $key = trim($_POST['key'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $pin = trim($_POST['pin'] ?? '');
    $product = trim($_POST['product'] ?? '');
    $variant = trim($_POST['variant'] ?? '');
    $p_key = trim($_POST['p_key'] ?? '');
    $l_key = trim($_POST['l_key'] ?? '');

    if (empty($company) || empty($city) || empty($country) || empty($mobile) || empty($address) || empty($email) || empty($key)) {
        session_start();
        $_SESSION['error'] = "(*) fields are required.";
        header("Location: add_client.php");
    } else {
        // Create Client id and time
        $cid = "CL" . date("YmdHis") . uniqid();
        $time = date("d-m-Y H:i:s"); // dd-mm-yyyy

        // New variables
        $status   = "active";
        $active_d = date("d-m-Y H:i:s"); // current date
        $expire_d = date("d-m-Y H:i:s", strtotime("+3 months")); // +3 months

        // Prepare query with new columns
        $stmt = $conn->prepare("
            INSERT INTO client 
            (cid, company_name, city, country, mobile, address, email, key_person, phone, pin, product, variant, p_key, l_key, time, status, active_d, expire_d) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "ssssssssssssssssss",
            $cid,
            $company,
            $city,
            $country,
            $mobile,
            $address,
            $email,
            $key,
            $phone,
            $pin,
            $product,
            $variant,
            $p_key,
            $l_key,
            $time,
            $status,
            $active_d,
            $expire_d
        );

        if ($stmt->execute()) {
            session_start();
            $_SESSION['success'] = "Client added successfully!";
            header("Location: client.php");
            exit();
        } else {
            session_start();
            $_SESSION['error'] = "Error: " . $stmt->error;
            header("Location: add_client.php");
            exit();
        }
    }
}
?>
