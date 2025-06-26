<?php
session_start();
require '../includes/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'parent') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Parent Dashboard</title>
    <style>
        .card { border: 1px solid #ccc; padding: 20px; margin: 10px; border-radius: 8px; }
    </style>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['username']; ?> (Parent)</h2>

    <div class="card"><a href="view_announcements.php">📢 View Announcements</a></div>
    <div class="card"><a href="child_performance.php">📚 View Child's Report</a></div>
    <div class="card"><a href="child_attendance.php">📆 Child Attendance</a></div>
    <div class="card"><a href="fee_invoice.php">💰 Check Fee Balance</a></div>
</body>
</html>
