<?php
session_start();
require 'connect.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$mpin = $_POST['mpin'] ?? null;
$password_id = $_POST['password_id'] ?? null;

if (!$password_id) {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}

// Fetch the hashed mPIN and check if 3FA is enabled
$stmt = $conn->prepare("SELECT mpin, is_mpin_enabled FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($hashed_mpin, $is_enabled);
$stmt->fetch();
$stmt->close();

// If 3FA is enabled, verify the mPIN
if ($is_enabled) {
    if (!$mpin) {
        echo json_encode(['success' => false, 'message' => 'mPIN is required.']);
        exit;
    }

    if (!password_verify($mpin, $hashed_mpin)) {
        echo json_encode(['success' => false, 'message' => 'Incorrect mPIN']);
        exit;
    }
}

// Fetch the encrypted password
$stmt = $conn->prepare("SELECT site_password FROM passwords WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $password_id, $user_id);
$stmt->execute();
$stmt->bind_result($encrypted_password);
$stmt->fetch();
$stmt->close();

if (!$encrypted_password) {
    echo json_encode(['success' => false, 'message' => 'Password not found.']);
    exit;
}

// Decrypt the password
$decryption_key = "your_secret_key_32_chars"; // Replace with your actual key
$iv = "1234567891011121"; // Replace with your actual IV
$decrypted_password = openssl_decrypt($encrypted_password, "AES-256-CBC", $decryption_key, 0, $iv);

if (!$decrypted_password) {
    echo json_encode(['success' => false, 'message' => 'Decryption failed.']);
    exit;
}

// Return the decrypted password
echo json_encode(['success' => true, 'password' => $decrypted_password]);
?>