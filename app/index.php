<?php
session_start();

if (isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'admin':
<<<<<<< HEAD
            header("Location: app/admin/dashboard.php");
=======
            header("Location: admin/dashboard.php");
>>>>>>> ea2e32e4e8a68f03162b30b5ef450c2b069c4c83
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
