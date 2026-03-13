<?php
// filepath: c:\xampp\htdocs\Vault\disable_3fa_request.php
session_start();
require 'connect.php';
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php");
    exit();
}

$stmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($email);
$stmt->fetch();
$stmt->close();

$otp = rand(100000, 999999);
$_SESSION['disable_3fa_otp'] = $otp;
$_SESSION['disable_3fa_email'] = $email;

// Send OTP via email
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'passvault2025@gmail.com'; // your Gmail
    $mail->Password   = 'cofa cfjm vhyq hpnp';    // your app password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('passvault2025@gmail.com', 'Password Vault');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'OTP to Disable 3FA';
    // Fetch user's name
    $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($username);
    $stmt->fetch();
    $stmt->close();

    $mail->Body = "Hi " . htmlspecialchars($username) . ",<br><br>You have recently requested to remove 3 Factor Authentication from your account. Use the OTP : <b>$otp</b> to disable 3FA. If it is not you, please ignore this email and please let us know!<br><br>Regards,<br>Password Vault Team";

    $mail->send();
} catch (Exception $e) {
    $_SESSION['disable_3fa_error'] = "Failed to send OTP. Try again.";
    header("Location: profile.php");
    exit();
}

header("Location: disable_3fa_otp_verify.php");
exit();