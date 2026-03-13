<?php
session_start();
require 'connect.php';

$email = $_SESSION['pending_email'];
$phone = $_SESSION['pending_phone'];
$email_otp = $_POST['email_otp'];

// Check OTPs
$stmt = $conn->prepare("SELECT * FROM pending_registrations WHERE email = ? AND phone = ? AND email_otp = ?");
$stmt->bind_param("sss", $email, $phone, $email_otp);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Move to users table
    $stmt2 = $conn->prepare("INSERT INTO users (username, email, phone, password) VALUES (?, ?, ?, ?)");
    $stmt2->bind_param("ssss", $row['name'], $row['email'], $row['phone'], $row['password']);
    $stmt2->execute();
    $stmt2->close();

    // Delete from pending_registrations
    $stmt3 = $conn->prepare("DELETE FROM pending_registrations WHERE id = ?");
    $stmt3->bind_param("i", $row['id']);
    $stmt3->execute();
    $stmt3->close();

    unset($_SESSION['pending_email'], $_SESSION['pending_phone']);
    header("Location: home_page.php");
    exit();
} else {
    $_SESSION['register_otp_error'] = true;
    header("Location: register_otp_verify.php");
    exit();
}
?>