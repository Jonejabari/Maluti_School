<!-- maluti_school_system/index.php -->

<?php
session_start();

if (isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'admin':
            header("Location: admin/dashboard.php");
            break;
        case 'teacher':
            header("Location: teacher/dashboard.php");
            break;
        case 'student':
            header("Location: student/dashboard.php");
            break;
        case 'parent':
            header("Location: parent/dashboard.php");
            break;
        default:
            header("Location: login.php");
            break;
    }
    exit();
} else {
    header("Location: login.php");
    exit();
}
