<?php
session_start();
$msg = "";

// ✅ Include your reusable DB connection
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $email = $conn->real_escape_string($_POST["email"]);
  $password = md5($_POST["password"]); // using md5 for compatibility

  // ✅ Query admin_users table
  $sql = "SELECT * FROM admin_users WHERE email='$email' AND password='$password'";
  $result = $conn->query($sql);

  if ($result && $result->num_rows == 1) {
    $_SESSION['admin_logged_in'] = true;
    header("Location: admin_dashboard.php");
    exit();
  } else {
    $msg = "Invalid email or password.";
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }

    body {
      background: url('image/BC4.jpg') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-box {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(12px);
      padding: 40px 35px;
      border-radius: 18px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.2);
      width: 340px;
      text-align: center;
      color: #fff;
      animation: fadeIn 0.8s ease-in-out;
    }

    .login-box h2 {
      margin-bottom: 25px;
      font-size: 26px;
      letter-spacing: 1px;
    }

    .login-box input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: none;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.2);
      color: #fff;
      font-size: 15px;
      outline: none;
    }

    .login-box input::placeholder {
      color: #ddd;
    }

    .login-box button {
      width: 100%;
      padding: 12px;
      margin-top: 10px;
      border: none;
      border-radius: 10px;
      background: linear-gradient(135deg, #6a11cb, #2575fc);
      color: #fff;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .login-box button:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .login-box .links {
      margin-top: 15px;
    }

    .login-box a {
      color: #f0f0f0;
      text-decoration: none;
      font-size: 14px;
      transition: color 0.3s ease;
    }
    .login-box a:hover {
      color: #ffdede;
    }

    .error {
      color: #ffbaba;
      background: rgba(255, 0, 0, 0.2);
      padding: 8px;
      margin-top: 12px;
      border-radius: 8px;
      font-size: 14px;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .back-home {
      position: absolute;
      top: 20px;
      left: 20px;
    }

    .back-home a {
      text-decoration: none;
      background: rgba(0, 0, 0, 0.55);
      color: white;
      padding: 10px 20px;
      border-radius: 8px;
      transition: background 0.3s ease;
    }

    .back-home a:hover {
      background: rgba(0,0,0,0.6);
    }
  </style>
</head>
<body>
  <div class="back-home">
    <a href="index.php">⬅ Back to Home</a>
  </div>

  <div class="login-box">
    <h2>🔐 Admin Login</h2>
    <form method="post">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>

      <div class="links">
        <p><a href="forgot_password.php">Forgot Password?</a></p>
      </div>

      <?php if (!empty($msg)): ?>
        <div class="error">⚠ <?= $msg ?></div>
      <?php endif; ?>
    </form>
  </div>
</body>
</html>
