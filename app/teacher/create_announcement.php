<?php
session_start();
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'teacher'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Announcement</title>
</head>
<body>
    <h2>Create Announcement</h2>
    <form action="save_announcement.php" method="POST">
        <label>Subject:</label><br>
        <input type="text" name="subject" required><br><br>

        <label>Message:</label><br>
        <textarea name="message" rows="6" cols="50" required></textarea><br><br>

        <label>Send To:</label><br>
        <select name="target_group" required>
            <option value="all">All</option>
            <option value="students">Students</option>
            <option value="parents">Parents</option>
        </select><br><br>

        <button type="submit">Send Announcement</button>
    </form>
</body>
</html>
