<?php
session_start();
include 'db_connect.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = $conn->real_escape_string(trim($_POST['email']    ?? ''));
    $password = md5($_POST['password'] ?? '');

    $sql    = "SELECT * FROM admin_users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin_dashboard.php');
        exit();
    } else {
        $msg = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login – UIU</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
  <link rel="stylesheet" href="style.css">
</head>
<body class="glass-page">
  <div class="back-home"><a href="index.php">&#8592; Back to Home</a></div>

  <div class="glass-box">
    <h2>&#128272; Admin Login</h2>
    <form method="post" action="">
      <input type="email"    name="email"    placeholder="Email"    required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
      <div class="links"><a href="forgot_password.php">Forgot Password?</a></div>
      <?php if ($msg): ?>
        <div class="error">&#9888; <?= htmlspecialchars($msg) ?></div>
      <?php endif; ?>
    </form>
  </div>
</body>
</html>
