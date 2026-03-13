<?php
session_start();
require 'connect.php';

if (!isset($_SESSION['pending_login_id'])) {
    header("Location: login.php");
    exit;
}

$pending_login_id = $_SESSION['pending_login_id'];
$email_otp = $_POST['email_otp'];

// Check OTPs
$stmt = $conn->prepare("SELECT * FROM pending_logins WHERE id = ? AND email_otp = ?");
$stmt->bind_param("is", $pending_login_id, $email_otp);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // OTPs correct, log user in
    $user_id = $row['user_id'];
    $stmt2 = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt2->bind_param("i", $user_id);
    $stmt2->execute();
    $user = $stmt2->get_result()->fetch_assoc();
    $stmt2->close();

    session_regenerate_id(true);
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['phone'] = $user['phone'];
    $_SESSION['email'] = $user['email'];
    unset($_SESSION['pending_login_id']);

    // Delete pending login
    $stmt3 = $conn->prepare("DELETE FROM pending_logins WHERE id = ?");
    $stmt3->bind_param("i", $pending_login_id);
    $stmt3->execute();
    $stmt3->close();

    header("Location: home_page.php");
    exit();
} else {
    // OTP incorrect: set error and redirect back
    $_SESSION['login_otp_error'] = true;
    header("Location: login_otp_verify.php");
    exit();
}
?>