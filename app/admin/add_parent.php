<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // 1. Add to users table
    $username = strtolower(str_replace(' ', '_', $name));
    $password = password_hash("default123", PASSWORD_DEFAULT);
    $role = 'parent';

    $stmtUser = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmtUser->bind_param("sss", $username, $password, $role);
    $stmtUser->execute();
    $user_id = $stmtUser->insert_id;

    // 2. Add to parents table
    $stmtParent = $conn->prepare("INSERT INTO parents (user_id, full_name, phone, email) VALUES (?, ?, ?, ?)");
    $stmtParent->bind_param("isss", $user_id, $name, $phone, $email);
    $stmtParent->execute();

    echo "✅ Parent created. Username: <b>$username</b>, Password: <b>default123</b>";
}
?>

<!DOCTYPE html>
<html>
<head><title>Add Parent</title></head>
<body>
<h2>Add New Parent</h2>
<form method="post">
    Name: <input type="text" name="full_name" required><br>
    Phone: <input type="text" name="phone"><br>
    Email: <input type="email" name="email"><br>
    <input type="submit" value="Create Parent">
</form>
</body>
</html>
