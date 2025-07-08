<?php
session_start();
include 'includes/db.php';

$token = $_GET['token'] ?? '';

$stmt = $conn->prepare("SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW()");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $_SESSION['reset_user_id'] = $result->fetch_assoc()['user_id'];
} else {
    die("Invalid or expired token.");
}
?>

<form action="reset_password_process.php" method="post">
    <label>New Password:</label><br>
    <input type="password" name="new_password" required><br><br>
    <input type="submit" value="Reset Password">
</form>
