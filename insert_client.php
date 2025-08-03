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
    $product =trim( $_POST['product'] ?? '');
    $variant = trim($_POST['variant'] ?? '');
    $p_key =trim( $_POST['p_key'] ?? '');
    $l_key = trim($_POST['l_key'] ?? '');

    $stmt = $conn->prepare("INSERT INTO client (company_name, city, country, mobile, address, email, key_person, phone, pin, product, variant, p_key, l_key) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssssssssss", $company, $city, $country, $mobile, $address, $email, $key, $phone, $pin, $product, $variant, $p_key, $l_key);
    $stmt->execute();

}
?>