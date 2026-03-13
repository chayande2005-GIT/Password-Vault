<?php
session_start();
require 'connect.php'; // your DB connection file

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$mpin = $_POST['mpin'];

if (!preg_match('/^\d{4}$/', $mpin)) {
    echo json_encode(['success' => false, 'message' => 'Invalid mPIN']);
    exit;
}

$stmt = $conn->prepare("SELECT is_mpin_enabled FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($is_mpin_enabled);
$stmt->fetch();
$stmt->close();

if ($is_mpin_enabled) {
    echo json_encode(['success' => false, 'message' => 'The mPIN already set, please disable it first from your profile.']);
    exit;
}

$hashed_mpin = password_hash($mpin, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE users SET mpin = ?, is_mpin_enabled = 1 WHERE id = ?");
$stmt->bind_param("si", $hashed_mpin, $user_id);
$stmt->execute();
$stmt->close();

echo json_encode(['success' => true, 'message' => 'You have set the mPIN successfully']);
?>
