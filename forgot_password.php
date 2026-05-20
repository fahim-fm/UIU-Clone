<?php
include 'db_connect.php';
$msg  = '';
$type = 'error';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email        = $conn->real_escape_string(trim($_POST['email'] ?? ''));
    $new_password = md5($_POST['new_password'] ?? '');

    $conn->query("UPDATE admin_users SET password='$new_password' WHERE email='$email'");

    if ($conn->affected_rows > 0) {
        $msg  = '✅ Password reset successfully. <a href="admin_login.php">Login Now</a>';
        $type = 'success';
    } else {
        $msg = '⚠️ Email not found or no change was made.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password – UIU</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
  <link rel="stylesheet" href="style.css">
</head>
<body class="glass-page">
  <div class="back-home"><a href="admin_login.php">&#8592; Back to Login</a></div>

  <div class="glass-box">
    <h2>🔒 Reset Password</h2>
    <?php if ($msg): ?>
      <div class="<?= $type === 'success' ? 'message' : 'error' ?>"><?= $msg ?></div>
    <?php endif; ?>
    <form method="post" action="">
      <input type="email"    name="email"        placeholder="Admin Email"   required>
      <input type="password" name="new_password" placeholder="New Password"  required>
      <button type="submit">Reset Password</button>
    </form>
  </div>
</body>
</html>
