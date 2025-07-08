<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];

// Get the current hashed password
$stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($current_password, $user['password'])) {
    // Update to new password
    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
    $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $update->bind_param("si", $hashed_new_password, $user_id);
    $update->execute();

    $_SESSION['change_success'] = "Password changed successfully.";
} else {
    $_SESSION['change_error'] = "Current password is incorrect.";
}

header("Location: change_password.php");
exit();
