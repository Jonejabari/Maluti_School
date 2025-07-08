<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>

    <?php if (isset($_SESSION['forgot_error'])): ?>
        <p style="color:red;"><?php echo $_SESSION['forgot_error']; unset($_SESSION['forgot_error']); ?></p>
    <?php elseif (isset($_SESSION['forgot_success'])): ?>
        <p style="color:green;"><?php echo $_SESSION['forgot_success']; unset($_SESSION['forgot_success']); ?></p>
    <?php endif; ?>

    <form action="forgot_password_process.php" method="post">
        <label>Enter your email or username:</label><br>
        <input type="text" name="identifier" required><br><br>
        <input type="submit" value="Send Reset Link">
    </form>
</body>
</html>
