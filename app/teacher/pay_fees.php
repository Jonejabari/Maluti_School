<?php
session_start();
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'teacher') {
    header("Location: ../login.php");
    exit();
}
include '../includes/db.php';

$students = $conn->query("SELECT * FROM students");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $amount = floatval($_POST['amount']);
    $paid = $_POST['paid'] == 'yes' ? 1 : 0;
    $date_paid = $paid ? $_POST['date_paid'] : null;

    if ($paid && empty($date_paid)) {
        $date_paid = date('Y-m-d');
    }

    $stmt = $conn->prepare("INSERT INTO fees (student_id, amount, paid, date_paid, recorded_by) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("idisi", $student_id, $amount, $paid, $date_paid, $_SESSION['user_id']);

    if ($stmt->execute()) {
        echo "<p>✅ Fee payment recorded!</p>";
    } else {
        echo "<p>❌ Error: " . $stmt->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Record Fee Payment</title>
    <script>
        function toggleDateInput() {
            const paid = document.querySelector("select[name='paid']").value;
            document.querySelector("input[name='date_paid']").disabled = (paid === 'no');
        }
    </script>
</head>
<body>
<h2>Record Fee Payment</h2>
<form method="post">
    Student:
    <select name="student_id" required>
        <?php while ($row = $students->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['full_name']) ?></option>
        <?php endwhile; ?>
    </select><br><br>

    Amount: <input type="number" step="0.01" name="amount" required><br><br>

    Paid: 
    <select name="paid" onchange="toggleDateInput()" required>
        <option value="yes">Yes</option>
        <option value="no">No</option>
    </select><br><br>

    Date Paid: <input type="date" name="date_paid"><br><br>

    <input type="submit" value="Record Payment">
</form>

<script>
    toggleDateInput(); // Run on page load
</script>
</body>
</html>
