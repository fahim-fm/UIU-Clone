<?php
session_start();
include 'db_connect.php';

// Registration
if (isset($_POST['register'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $check = $conn->query("SELECT * FROM students WHERE email='$email'");
  if ($check->num_rows > 0) {
    $msg = "Email already registered.";
  } else {
    $conn->query("INSERT INTO students (name, email, password) VALUES ('$name', '$email', '$password')");
    $msg = "✅ Registered successfully. You can login now.";
  }
}

// Login
if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $result = $conn->query("SELECT * FROM students WHERE email='$email'");
  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      $_SESSION['student'] = $row;
      header("Location: student_dashboard.php");
      exit;
    } else {
      $msg = "❌ Incorrect password.";
    }
  } else {
    $msg = "❌ No account found.";
  }
}

// Logout
if (isset($_GET['logout'])) {
  session_destroy();
  header("Location: student_auth.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Student Login & Register</title>
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

    .container {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(12px);
      max-width: 400px;
      width: 90%;
      padding: 35px;
      border-radius: 18px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.2);
      animation: fadeIn 0.8s ease-in-out;
      text-align: center;
      color: #fff;
    }

    h2 {
      margin-bottom: 20px;
      font-size: 26px;
      letter-spacing: 1px;
    }

    input {
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

    input::placeholder {
      color: #ddd;
    }

    button {
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

    button:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .switch, .links {
      margin-top: 15px;
    }

    .switch a, .links a {
      color: #f0f0f0;
      text-decoration: none;
      font-size: 14px;
      transition: color 0.3s ease;
    }
    .switch a:hover, .links a:hover {
      color: #ffdede;
    }

    .msg {
      background: rgba(0, 0, 0, 0.2);
      padding: 8px;
      margin-bottom: 12px;
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
      background: rgba(0,0,0,0.4);
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
<div class="container">
  <?php if (isset($_SESSION['student'])): ?>
    <?php header("Location: student_dashboard.php"); exit; ?>
  <?php else: ?>
    <h2><?= isset($_GET['action']) && $_GET['action'] == 'register' ? '📝 Register' : '🔑 Login' ?></h2>

    <?php if (isset($msg)): ?>
      <div class="msg"><?= $msg ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['action']) && $_GET['action'] == 'register'): ?>
      <form method="post">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="register">Register</button>
      </form>
      <div class="switch">Already registered? <a href="student_auth.php">Login</a></div>
      <div class="links"><a href="index.php">⬅ Back to Home</a></div>

    <?php else: ?>
      <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
      </form>
      
      <div class="switch">New student? <a href="?action=register">Register</a></div>
    <?php endif; ?>
  <?php endif; ?>
</div>
</body>
</html>
