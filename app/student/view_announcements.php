<?php
session_start();
require '../includes/db.php'; // '../db.php' if not in root

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// here i convert singular role to plural for matching target_group
$role_for_target = $role === 'parent' ? 'parents' : ($role === 'student' ? 'students' : $role);

// Optionally filter for student/parent based on target group
$sql = "SELECT * FROM notifications 
        WHERE target_group = 'all' OR target_group = ?
        ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $role_for_target);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Announcements</title>
</head>
<body>
    <h2>📢 Announcements</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>Subject</th>
            <th>Message</th>
            <th>To</th>
            <th>By</th>
            <th>Date</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['subject']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                <td><?php echo ucfirst($row['target_group']); ?></td>
                <td><?php echo ucfirst($row['role']); ?></td>
                <td><?php echo $row['created_at']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
