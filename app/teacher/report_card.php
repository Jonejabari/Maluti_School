<?php
session_start();
include '../includes/db.php';

$student_id = $_SESSION['role'] === 'student' ? $_SESSION['student_id'] : ($_GET['student_id'] ?? 0);
$term = $_GET['term'] ?? 'Term 1';

$stmt = $conn->prepare("SELECT subject, marks_obtained, max_marks FROM exams WHERE student_id = ? AND term = ?");
$stmt->bind_param("is", $student_id, $term);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
$max_total = 0;
$rows = [];

while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
    $total += $row['marks_obtained'];
    $max_total += $row['max_marks'];
}
?>
<!DOCTYPE html>
<html>
<head><title>Report Card</title></head>
<body>
<h2>Report Card – <?= htmlspecialchars($term) ?></h2>
<table border="1" cellpadding="5">
    <tr><th>Subject</th><th>Marks Obtained</th><th>Max Marks</th></tr>
    <?php foreach ($rows as $row): ?>
    <tr>
        <td><?= $row['subject'] ?></td>
        <td><?= $row['marks_obtained'] ?></td>
        <td><?= $row['max_marks'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<p><strong>Total: <?= $total ?> / <?= $max_total ?></strong></p>
<p><strong>Percentage: <?= round(($total / $max_total) * 100, 2) ?>%</strong></p>
</body>
</html>
