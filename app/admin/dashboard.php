<?php
session_start();
require '../includes/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        .card { border: 1px solid #ccc; padding: 20px; margin: 10px; border-radius: 8px; }
    </style>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['username']; ?> (Admin)</h2>

    <div class="card">📊 Total Students:
        <?php
            $res = $conn->query("SELECT COUNT(*) AS total FROM students");
            echo $res->fetch_assoc()['total'];
        ?>
    </div>

    <div class="card">👨‍🏫 Total Teachers:
        <?php
            $res = $conn->query("SELECT COUNT(*) AS total FROM teachers");
            echo $res->fetch_assoc()['total'];
        ?>
    </div>

    <div class="card">💵 Total Fees Collected:
    <?php
        $res = $conn->query("SELECT SUM(amount) AS total FROM fees WHERE paid = 1");
        echo 'M ' . number_format($res->fetch_assoc()['total'], 2);
    ?>
</div>
<div class="card">⏳ Pending Fees:
    <?php
        $res = $conn->query("SELECT SUM(amount) AS total FROM fees WHERE paid = 0");
        $total = $res->fetch_assoc()['total'];
        echo 'M ' . number_format($total ?? 0, 2);
    ?>
</div>
<div class="card">
    <h3>📋 Students with Pending Fees</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Student Name</th>
            <th>Amount Pending</th>
            <th>Last Payment Date</th>
	    <th>Action</th>
        </tr>
        <?php
             $query = "
            SELECT s.id AS student_id, s.full_name, s.parent_contact, f.amount, f.date_paid 
            FROM fees f
            JOIN students s ON f.student_id = s.id
            WHERE f.paid = 0
        ";
        $result = $conn->query($query);

            if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['full_name']}</td>
                        <td>M " . number_format($row['amount'], 2) . "</td>
                        <td>" . ($row['date_paid'] ?? 'N/A') . "</td>
                        <td>
                            <form action='send_reminder.php' method='post' style='margin:0'>
                                <input type='hidden' name='student_id' value='{$row['student_id']}'>
                                <input type='hidden' name='parent_contact' value='{$row['parent_contact']}'>
                                <input type='submit' value='Send Reminder'>
                            </form>
                        </td>
                      </tr>";
            }
            } else {
                echo "<tr><td colspan='3'>No pending fees.</td></tr>";
            }
        ?>


    </table>
</div>

</body>
</html>
