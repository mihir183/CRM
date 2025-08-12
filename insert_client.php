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
        $_SESSION['error'] = "(*) fields is required.";
        header("Location: add_client.php");
    } else {

        $stmt = $conn->prepare("INSERT INTO client (cid, company_name, city, country, mobile, address, email, key_person, phone, pin, product, variant, p_key, l_key,time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // create Client id and time

        $cid = "CL" . date("YmdHis") . uniqid();
        $time = date("Y-m-d H:i:s");

        $stmt->bind_param("sssssssssssssss", $cid,$company, $city, $country, $mobile, $address, $email, $key, $phone, $pin, $product, $variant, $p_key, $l_key, $time);
        // $stmt->execute();

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