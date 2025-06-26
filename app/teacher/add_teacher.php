<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $class = $_POST['class_assigned'];

    $stmt = $conn->prepare("INSERT INTO teachers (full_name, gender, email, phone, subject, class_assigned) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $gender, $email, $phone, $subject, $class);
    $stmt->execute();

    header("Location: teachers.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Add Teacher</title></head>
<body>
<h2>Add New Teacher</h2>
<form method="post">
    Name: <input type="text" name="full_name" required><br>
    Gender: 
    <select name="gender">
        <option>Male</option>
        <option>Female</option>
    </select><br>
    Email: <input type="email" name="email"><br>
    Phone: <input type="text" name="phone"><br>
    Subject: <input type="text" name="subject"><br>
    Class Assigned: <input type="text" name="class_assigned"><br>
    <input type="submit" value="Add Teacher">
</form>
</body>
</html>
