<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM teachers WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$teacher = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $class = $_POST['class_assigned'];

    $update = $conn->prepare("UPDATE teachers SET full_name=?, gender=?, email=?, phone=?, subject=?, class_assigned=? WHERE id=?");
    $update->bind_param("ssssssi", $name, $gender, $email, $phone, $subject, $class, $id);
    $update->execute();

    header("Location: teachers.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit Teacher</title></head>
<body>
<h2>Edit Teacher</h2>
<form method="post">
    Name: <input type="text" name="full_name" value="<?= $teacher['full_name'] ?>" required><br>
    Gender: 
    <select name="gender">
        <option <?= $teacher['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
        <option <?= $teacher['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
    </select><br>
    Email: <input type="email" name="email" value="<?= $teacher['email'] ?>"><br>
    Phone: <input type="text" name="phone" value="<?= $teacher['phone'] ?>"><br>
    Subject: <input type="text" name="subject" value="<?= $teacher['subject'] ?>"><br>
    Class Assigned: <input type="text" name="class_assigned" value="<?= $teacher['class_assigned'] ?>"><br>
    <input type="submit" value="Update Teacher">
</form>
</body>
</html>
