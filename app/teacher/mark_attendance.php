<?php
session_start();
if ($_SESSION['role'] !== 'teacher') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

// Get students (can be filtered by class if needed)
$students = $conn->query("SELECT * FROM students");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'] ?? date('Y-m-d');

    foreach ($_POST['attendance'] as $student_id => $status) {
        $stmt = $conn->prepare("INSERT INTO attendance (student_id, date, status, recorded_by) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issi", $student_id, $date, $status, $_SESSION['user_id']);
        $stmt->execute();
    }

    echo "<p>Attendance recorded for $date!</p>";
}
?>
<!DOCTYPE html>
<html>
<head><title>Mark Attendance</title></head>
<body>
<h2>Mark Attendance</h2>
<form method="post">
    Date: <input type="date" name="date" value="<?= date('Y-m-d') ?>"><br><br>
    <table border="1" cellpadding="5">
        <tr><th>Student Name</th><th>Status</th></tr>
        <?php while ($student = $students->fetch_assoc()): ?>
        <tr>
            <td><?= $student['full_name'] ?></td>
            <td>
                <select name="attendance[<?= $student['id'] ?>]">
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                </select>
            </td>
        </tr>
        <?php endwhile; ?>
    </table><br>
    <input type="submit" value="Submit Attendance">
</form>
</body>
</html>
