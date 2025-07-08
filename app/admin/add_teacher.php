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

    // Create username from email or name
    $username = explode('@', $email)[0] ?? strtolower(str_replace(' ', '', $name)) . rand(100, 999);
    $raw_password = 'pass123'; // default temp password
    $hashed_password = password_hash($raw_password, PASSWORD_BCRYPT);

    // Insert into users table
    $stmtUser = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'teacher')");
    $stmtUser->bind_param("ss", $username, $hashed_password);
    $stmtUser->execute();
    $user_id = $conn->insert_id;

    // Insert into teachers table
    $stmtTeacher = $conn->prepare("INSERT INTO teachers (user_id, full_name, gender, email, phone, subject, class_assigned) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmtTeacher->bind_param("issssss", $user_id, $name, $gender, $email, $phone, $subject, $class);
    $stmtTeacher->execute();

    // Show credentials
    echo "<h3>✅ Teacher created successfully!</h3>";
    echo "<p><strong>Username:</strong> $username</p>";
    echo "<p><strong>Password:</strong> $raw_password</p>";
    echo "<a href='teachers.php'>⬅️ Back to Teachers</a>";
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
