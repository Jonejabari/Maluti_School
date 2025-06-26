<?php
session_start();
require '../db.php';


if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'teacher'])) {
    header("Location: login.php");
    exit();
}

$sender_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$subject = $_POST['subject'];
$message = $_POST['message'];
$target = $_POST['target_group'];

$sql = "INSERT INTO notifications (sender_id, role, subject, message, target_group)
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issss", $sender_id, $role, $subject, $message, $target);

if ($stmt->execute()) {
    echo "Announcement posted!";
} else {
    echo "Error: " . $stmt->error;
}
?>
