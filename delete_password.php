<?php
session_start();
include("connect.php");

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    die(json_encode(['success' => false, 'message' => 'User not logged in.']));
}

$mpin = $_POST['mpin'] ?? '';
$password_id = $_POST['password_id'] ?? '';

// Check if MPIN is enabled
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


$stmt = $conn->prepare("DELETE FROM passwords WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $password_id, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Deletion failed']);
}
?>
