<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

$result = $conn->query("SELECT * FROM teachers");
?>
<!DOCTYPE html>
<html>
<head><title>Teachers</title></head>
<body>
<h2>Teacher Records</h2>
<a href="add_teacher.php">Add Teacher</a> | <a href="dashboard.php">Back to Dashboard</a><br><br>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th><th>Name</th><th>Gender</th><th>Email</th><th>Phone</th><th>Subject</th><th>Class</th><th>Actions</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['full_name'] ?></td>
        <td><?= $row['gender'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $row['phone'] ?></td>
        <td><?= $row['subject'] ?></td>
        <td><?= $row['class_assigned'] ?></td>
        <td>
            <a href="edit_teacher.php?id=<?= $row['id'] ?>">Edit</a> |
            <a href="delete_teacher.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this teacher?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
