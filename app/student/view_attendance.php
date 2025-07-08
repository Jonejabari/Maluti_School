<?php
session_start();
include '../includes/db.php';

// $student_id = $_SESSION['role'] === 'student' ? $_SESSION['student_id'] : $_GET['student_id'] ?? 0;
$student_id = ($_SESSION['role'] === 'student') ? $_SESSION['user_id'] : ($_GET['student_id'] ?? 0);

if (!$student_id) {
    echo "No student selected.";
    exit();
}

$result = $conn->prepare("SELECT date, status FROM attendance WHERE student_id = ? ORDER BY date DESC");
$result->bind_param("i", $student_id);
$result->execute();
$records = $result->get_result();
?>
<!DOCTYPE html>
<html>
<head><title>Attendance Records</title></head>
<body>
<h2>Attendance History</h2>
<table border="1" cellpadding="5">
    <tr><th>Date</th><th>Status</th></tr>
    <?php while ($row = $records->fetch_assoc()): ?>
    <tr>
        <td><?= $row['date'] ?></td>
        <td><?= $row['status'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
