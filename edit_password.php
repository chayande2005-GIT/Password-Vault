<?php
session_start();
include("connect.php");


$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    die(json_encode(['success' => false, 'message' => 'User not logged in.']));
}

$mpin = $_POST['mpin'] ?? '';
$password_id = $_POST['password_id'] ?? '';
$site_name = $_POST['site_name'] ?? '';
$site_url = $_POST['site_url'] ?? '';
$site_username = $_POST['site_username'] ?? '';
$site_password_plain = $_POST['site_password'] ?? '';




// Check if mPIN is enabled
$stmt = $conn->prepare("SELECT mpin, is_mpin_enabled FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($real_mpin, $is_enabled);
$stmt->fetch();
$stmt->close();

if ($is_enabled && !password_verify($mpin, $real_mpin)) {
    echo json_encode(['success' => false, 'message' => 'Invalid mPIN']);
    exit;
}

// 🔐 Encrypt the password before saving
// Encryption key (store securely in an env file)
    $key = "your_secret_key_32_chars"; 
    $iv = "1234567891011121"; 

    // Encrypt the password using AES-256-CBC
    $encrypted_password = openssl_encrypt($site_password_plain, "AES-256-CBC", $key, 0, $iv);

// Update the password entry
$stmt = $conn->prepare("UPDATE passwords SET site_name=?, site_url=?, site_username=?, site_password=? WHERE id=? AND user_id=?");
$stmt->bind_param("ssssii", $site_name, $site_url, $site_username, $encrypted_password, $password_id, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Update failed']);
}
?>
