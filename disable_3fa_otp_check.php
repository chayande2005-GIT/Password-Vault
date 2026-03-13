<?php
// filepath: c:\xampp\htdocs\Vault\disable_3fa_otp_check.php
session_start();
require 'connect.php';

$user_id = $_SESSION['user_id'] ?? null;
$entered_otp = $_POST['otp'] ?? '';
$session_otp = $_SESSION['disable_3fa_otp'] ?? '';

if (!$user_id || !$entered_otp || !$session_otp) {
    $_SESSION['disable_3fa_otp_error'] = "Invalid request.";
    header("Location: disable_3fa_otp_verify.php");
    exit();
}

if ($entered_otp == $session_otp) {
    // Disable 3FA
    $stmt = $conn->prepare("UPDATE users SET is_mpin_enabled = 0 WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    unset($_SESSION['disable_3fa_otp'], $_SESSION['disable_3fa_email']);
    header("Location: profile.php");
    exit();
} else {
    $_SESSION['disable_3fa_otp_error'] = "Invalid OTP, please try again!";
    header("Location: disable_3fa_otp_verify.php");
    exit();
}