<?php
include 'includes/db.php';

$username = 'Jone';
$query = $conn->prepare("SELECT * FROM users WHERE username = ?");
$query->bind_param("s", $username);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    echo "User found: " . $user['username'] . " | Role: " . $user['role'] . "<br>";
    if (password_verify("123456", $user['password'])) {
        echo "Password matches!";
    } else {
        echo "Password does NOT match!";
    }
} else {
    echo "User not found.";
}
