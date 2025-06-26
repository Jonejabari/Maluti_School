<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

$id = $_GET['id'];
$result = $conn->prepare("SELECT * FROM students WHERE id = ?");
$result->bind_param("i", $id);
$result->execute();
$student = $result->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $class = $_POST['class'];
    $year = $_POST['academic_year'];
    $contact = $_POST['parent_contact'];

    $update = $conn->prepare("UPDATE students SET full_name=?, gender=?, dob=?, class=?, academic_year=?, parent_contact=? WHERE id=?");
    $update->bind_param("ssssssi", $name, $gender, $dob, $class, $year, $contact, $id);
    $update->execute();

    header("Location: students.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit Student</title></head>
<body>
<h2>Edit Student</h2>
<form method="post">
    Name: <input type="text" name="full_name" value="<?= $student['full_name'] ?>" required><br>
    Gender: 
    <select name="gender">
        <option <?= $student['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
        <option <?= $student['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
    </select><br>
    DOB: <input type="date" name="dob" value="<?= $student['dob'] ?>"><br>
    Class: <input type="text" name="class" value="<?= $student['class'] ?>"><br>
    Academic Year: <input type="text" name="academic_year" value="<?= $student['academic_year'] ?>"><br>
    Parent Contact: <input type="text" name="parent_contact" value="<?= $student['parent_contact'] ?>"><br>
    <input type="submit" value="Update Student">
</form>
</body>
</html>
