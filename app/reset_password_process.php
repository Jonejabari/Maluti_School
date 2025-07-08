<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['reset_user_id'])) {
    die("Unauthorized access.");
}

$new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
$user_id = $_SESSION['reset_user_id'];

$stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
$stmt->bind_param("si", $new_password, $user_id);
$stmt->execute();

// Clean up
$conn->query("DELETE FROM password_resets WHERE user_id = $user_id");
unset($_SESSION['reset_user_id']);

echo "Password has been reset. <a href='login.php'>Login now</a>";
