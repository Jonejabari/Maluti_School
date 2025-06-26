<?php
session_start();
if ($_SESSION['role'] !== 'teacher') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

$students = $conn->query("SELECT * FROM students");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $subject = $_POST['subject'];
    $marks = $_POST['marks_obtained'];
    $term = $_POST['term'];

    $stmt = $conn->prepare("INSERT INTO exams (student_id, subject, marks_obtained, term, recorded_by) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isisi", $student_id, $subject, $marks, $term, $_SESSION['user_id']);
    $stmt->execute();

    echo "<p>Grade recorded!</p>";
}
?>
<!DOCTYPE html>
<html>
<head><title>Enter Grades</title></head>
<body>
<h2>Enter Student Grades</h2>
<form method="post">
    Student:
    <select name="student_id">
        <?php while ($row = $students->fetch_assoc()): ?>
        <option value="<?= $row['id'] ?>"><?= $row['full_name'] ?></option>
        <?php endwhile; ?>
    </select><br>
    Subject: <input type="text" name="subject" required><br>
    Marks Obtained: <input type="number" name="marks_obtained" min="0" max="100" required><br>
    Term: 
    <select name="term">
        <option value="Term 1">Term 1</option>
        <option value="Term 2">Term 2</option>
        <option value="Term 3">Term 3</option>
    </select><br>
    <input type="submit" value="Submit Grade">
</form>
</body>
</html>
