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
    $dob = $_POST['dob'];
    $class = $_POST['class'];
    $year = $_POST['academic_year'];
    $contact = $_POST['parent_contact'];

    $stmt = $conn->prepare("INSERT INTO students (full_name, gender, dob, class, academic_year, parent_contact) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $gender, $dob, $class, $year, $contact);
    $stmt->execute();

    header("Location: students.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Add Student</title></head>
<body>
<h2>Add New Student</h2>
<form method="post">
    Name: <input type="text" name="full_name" required><br>
    Gender: 
    <select name="gender">
        <option>Male</option>
        <option>Female</option>
    </select><br>
    DOB: <input type="date" name="dob"><br>
    Class: <input type="text" name="class"><br>
    Academic Year: <input type="text" name="academic_year"><br>
    Parent Contact: <input type="text" name="parent_contact"><br>
    <input type="submit" value="Add Student">
</form>
</body>
</html>
