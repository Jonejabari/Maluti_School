<?php
session_start();
require '../includes/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <style>
        .card { border: 1px solid #ccc; padding: 20px; margin: 10px; border-radius: 8px; }
    </style>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['username']; ?> (Student)</h2>

    <div class="card"><a href="view_announcements.php">📢 View Announcements</a></div>
    <div class="card"><a href="view_grades.php">📑 View Report Card</a></div>
    <div class="card"><a href="view_attendance.php">📅 View Attendance</a></div>
    <div class="card"><a href="fee_status.php">💵 View Fee Status</a></div>
</body>
</html>
