<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

$result = $conn->query("SELECT * FROM students");
?>
<!DOCTYPE html>
<html>
<head><title>Students</title></head>
<body>
<h2>Student Records</h2>
<a href="add_student.php">Add Student</a> | <a href="dashboard.php">Back to Dashboard</a><br><br>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th><th>Name</th><th>Gender</th><th>DOB</th><th>Class</th><th>Academic Year</th><th>Parent Contact</th><th>Actions</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['full_name'] ?></td>
        <td><?= $row['gender'] ?></td>
        <td><?= $row['dob'] ?></td>
        <td><?= $row['class'] ?></td>
        <td><?= $row['academic_year'] ?></td>
        <td><?= $row['parent_contact'] ?></td>
        <td>
            <a href="edit_student.php?id=<?= $row['id'] ?>">Edit</a> | 
            <a href="delete_student.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this student?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
