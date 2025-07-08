<?php
session_start();
include 'includes/db.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = $conn->prepare("SELECT * FROM users WHERE username = ?");
$query->bind_param("s", $username);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        switch ($user['role']) {
            case 'admin':
                header("Location: admin/dashboard.php");
                break;
            case 'teacher':
                header("Location: teacher/dashboard.php");
                break;
            case 'student':
                header("Location: student/dashboard.php");
                break;
            case 'parent':
                header("Location: parent/dashboard.php");
                break;
 	default:
        header("Location: login.php");
        }
        exit();
    }
}

$_SESSION['error'] = "Invalid username or password.";
header("Location: login.php");
exit();
