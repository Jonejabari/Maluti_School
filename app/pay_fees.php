<?php
session_start();
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'teacher') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

$students = $conn->query("SELECT * FROM students");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $amount = $_POST['amount'];
    $paid = $_POST['paid'] == 'yes' ? 1 : 0;
    $date_paid = $paid ? $_POST['date_paid'] : null;

    $stmt = $conn->prepare("INSERT INTO fees (student_id, amount, paid, date_paid, recorded_by) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isisi", $student_id, $amount, $paid, $date_paid, $_SESSION['user_id']);
    $stmt->execute();

    echo "<p>Fee payment recorded!</p>";
}
?>
<!DOCTYPE html>
<html>
<head><title>Pay Fees</title></head>
<body>
<h2>Record Fee Payment</h2>
<form method="post">
    Student:
    <select name="student_id">
        <?php while ($row = $students->fetch_assoc()): ?>
        <option value="<?= $row['id'] ?>"><?= $row['full_name'] ?></option>
        <?php endwhile; ?>
    </select><br>
    Amount: <input type="number" step="0.01" name="amount" required><br>
    Paid: 
    <select name="paid">
        <option value="yes">Yes</option>
        <option value="no">No</option>
    </select><br>
    Date Paid: <input type="date" name="date_paid"><br>
    <input type="submit" value="Record Payment">
</form>
</body>
</html>
