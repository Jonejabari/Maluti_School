<?php
session_start();
include '../includes/db.php';

$student_id = $_SESSION['role'] === 'student' ? $_SESSION['student_id'] : ($_GET['student_id'] ?? 0);

if (!$student_id) {
    echo "No student selected.";
    exit();
}

$stmt = $conn->prepare("SELECT amount, paid, date_paid FROM fees WHERE student_id = ? ORDER BY date_paid DESC");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$balance = 0;
?>
<!DOCTYPE html>
<html>
<head><title>Fee Invoice</title></head>
<body>
<h2>Fee Invoice</h2>
<table border="1" cellpadding="5">
    <tr><th>Date</th><th>Amount</th><th>Status</th></tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['date_paid'] ? $row['date_paid'] : 'Pending' ?></td>
        <td><?= $row['amount'] ?></td>
        <td><?= $row['paid'] ? 'Paid' : 'Pending' ?></td>
    </tr>
    <?php 
        if (!$row['paid']) $balance += $row['amount'];
    endwhile;
    ?>
</table>
<p><strong>Outstanding Balance: <?= $balance ?></strong></p>
</body>
</html>
