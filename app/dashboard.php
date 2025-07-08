<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - <?php echo ucfirst($role); ?></title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .card { border: 1px solid #ccc; border-radius: 8px; padding: 15px; margin: 10px 0; }
    </style>
    <p>You are logged in as <strong><?php echo $role; ?></strong></p>

    <?php if ($role == 'admin'): ?>
        <div class="card">📊 Total Students: 
            <?php
                $res = $conn->query("SELECT COUNT(*) AS total FROM students");
                echo $res->fetch_assoc()['total'];
            ?>
        </div>
        <div class="card">👨‍🏫 Total Teachers:
            <?php
                $res = $conn->query("SELECT COUNT(*) AS total FROM teachers");
                echo $res->fetch_assoc()['total'];
            ?>
        </div>
        <div class="card">💵 Total Fees Collected:
            <?php
                $res = $conn->query("SELECT SUM(amount_paid) AS total FROM fees");
                echo 'M ' . number_format($res->fetch_assoc()['total'], 2);
            ?>
        </div>

    <?php elseif ($role == 'teacher'): ?>
        <div class="card">📅 View your class schedules</div>
        <div class="card">📘 Enter attendance</div>
        <div class="card"><a href="teacher/create_announcement.php">📢 Post Announcement</a></div>

    <?php elseif ($role == 'student'): ?>
        <div class="card"><a href="view_announcements.php">📢 Announcements</a></div>
        <div class="card">📚 View Report Card</div>
        <div class="card">🕒 View Attendance</div>

    <?php elseif ($role == 'parent'): ?>
        <div class="card"><a href="view_announcements.php">📢 Announcements</a></div>
        <div class="card">👩‍🎓 Child Performance</div>
        <div class="card">🕒 Attendance Overview</div>
    <?php endif; ?>
</body>
</html>
