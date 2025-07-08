<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include('../includes/db.php');

$loginInfo = ''; // Used to display login credentials after submission

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $class = $_POST['class'];
    $year = $_POST['academic_year'];
    $contact = $_POST['parent_contact'];

    // Generate a clean username
    $baseUsername = strtolower(preg_replace('/\s+/', '', $name)); // Remove spaces
    $username = $baseUsername . rand(100, 999); // Make it unique-ish

    $defaultPassword = "student123";
    $hashedPassword = password_hash($defaultPassword, PASSWORD_BCRYPT);

    // Insert into users table
    // $stmtUser = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'student')");
    // $stmtUser->bind_param("ss", $username, $hashedPassword);
    // $stmtUser->execute();
    // $user_id = $conn->insert_id;
    $stmtUser = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'student')");
    $stmtUser->bind_param("ss", $username, $hashedPassword);
    $stmtUser->execute();
    $user_id = $conn->insert_id;

    // Insert into students table
    // $stmtStudent = $conn->prepare("INSERT INTO students (user_id, full_name, gender, dob, class, academic_year, parent_contact) VALUES (?, ?, ?, ?, ?, ?, ?)");
    // $stmtStudent->bind_param("issssss", $user_id, $name, $gender, $dob, $class, $year, $contact);
    // $stmtStudent->execute();
    $stmtStudent = $conn->prepare("INSERT INTO students (user_id, full_name, gender, dob, class, academic_year, parent_contact) 
    VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmtStudent->bind_param("issssss", $user_id, $name, $gender, $dob, $class, $year, $contact);
    $stmtStudent->execute();

    // Show login credentials
    $loginInfo = "✅ Student added successfully!<br>
                  🔐 Username: <strong>$username</strong><br>
                  🔑 Default Password: <strong>$defaultPassword</strong>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
</head>
<body>
<h2>Add New Student</h2>

<?php if (!empty($loginInfo)): ?>
    <div style="background-color: #e0ffe0; padding: 10px; border: 1px solid green; margin-bottom: 15px;">
        <?= $loginInfo ?>
    </div>
<?php endif; ?>

<form method="post">
    Name: <input type="text" name="full_name" required><br>
    Gender: 
    <select name="gender">
        <option>Male</option>
        <option>Female</option>
    </select><br>
    DOB: <input type="date" name="dob"><br>
    Class: <input type="text" name="class"><br>
    Academic Year: <input type="text" name="academic_year"><br>
    Parent Contact: <input type="text" name="parent_contact"><br>
    <input type="submit" value="Add Student">
</form>
</body>
</html>
