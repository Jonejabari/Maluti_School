<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../login.php");
    exit();
}

$teacher_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Dashboard</title>
    <style>
        .card { border: 1px solid #ccc; padding: 20px; margin: 10px; border-radius: 8px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { padding: 8px 12px; border: 1px solid #ccc; }
    </style>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['username']; ?> (Teacher)</h2>

    <div class="card"><a href="mark_attendance.php">📋 Mark Attendance</a></div>
    <div class="card"><a href="enter_grades.php">📝 Enter Grades</a></div>
    <div class="card"><a href="create_announcement.php">📢 Post Announcement</a></div>

    <div class="card">
        <h3>🏫 Your Assigned Classes</h3>
        <?php
        // Example assumes there's a table: teacher_classes (id, teacher_id, class_name, subject_name)
        $result = $conn->query("SELECT class_name, subject_name FROM teacher_classes WHERE teacher_id = $teacher_id");

        if ($result->num_rows > 0) {
            echo "<table><tr><th>Class</th><th>Subject</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>{$row['class_name']}</td><td>{$row['subject_name']}</td></tr>";
            }
            echo "</table>";
        } else {
            echo "You have not been assigned any classes yet.";
        }
        ?>
    </div>
</body>
</html>
