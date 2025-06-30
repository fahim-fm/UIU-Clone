<?php
session_start();
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $conn = new mysqli("localhost", "root", "", "notice");
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $email = $_POST["email"];
  $password = md5($_POST["password"]); // Use md5 if stored that way

  $sql = "SELECT * FROM admin_users WHERE email='$email' AND password='$password'";
  $result = $conn->query($sql);

  if ($result->num_rows == 1) {
    $_SESSION['admin_logged_in'] = true;
    header("Location: admin_dashboard.php");
    exit();
  } else {
    $msg = "Invalid email or password.";
  }

  $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <style>
    body {
      font-family: Arial;
     background: url('image/BC4.jpg') no-repeat center center fixed;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .login-box {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px #ccc;
      width: 300px;
    }
    h2 {
      text-align: center;
    }
    input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
    }
    .error {
      color: red;
      text-align: center;
      margin-top: 10px;
    }
    button {
      background: #007BFF;
      color: white;
      border: none;
      width: 100%;
      padding: 10px;
      cursor: pointer;
    }
    button:hover {
      background: #0056b3;
    }
  </style>
</head>
<body>
    
  <div class="login-box">
    <h2>Admin Login</h2>
    <form method="post">
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit">Login</button>
      <p style="text-align: center; margin-top: 10px;">
  <a href="forgot_password.php">Forgot Password?</a>
</p>

      <?php if ($msg): ?>
        <div class="error"><?= $msg ?></div>
      <?php endif; ?>
    </form>
    <a href="index.php">
  <button style="margin-top: 15px; background-color: #28a745;">Back to Home</button>
</a>
  </div>
</body>
</html>
