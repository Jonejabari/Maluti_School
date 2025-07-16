<?php
session_start();
include 'includes/db.php';

$identifier = $_POST['identifier'];

$query = $conn->prepare("SELECT id, email FROM users WHERE username = ? OR email = ?");
$query->bind_param("ss", $identifier, $identifier);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $token = bin2hex(random_bytes(32));
    $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

    // Save token to a password_resets table
    $stmt = $conn->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user['id'], $token, $expires);
    $stmt->execute();

    $reset_link = "http://yourdomain.com/reset_password.php?token=$token";

    // email it (for testing we can just display the link)
    $_SESSION['forgot_success'] = "A password reset link has been sent to your email.";
    // In real usage, send the $reset_link via email using PHPMailer or mail()

    // For now, echo the reset link:
    echo "Reset your password: <a href='$reset_link'>$reset_link</a>";
    exit();
} else {
    $_SESSION['forgot_error'] = "User not found.";
    header("Location: forgot_password.php");
    exit();
}
