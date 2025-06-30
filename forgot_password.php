<?php
include 'db_connect.php'; // ✅ Reuse DB connection
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $new_password = md5($_POST["new_password"]); // Use md5 only if already used

  $sql = "UPDATE admin_users SET password='$new_password' WHERE email='$email'";
  $result = $conn->query($sql);

  if ($conn->affected_rows > 0) {
    $msg = "Password has been reset successfully. <a href='admin_login.php'>Login Now</a>";
  } else {
    $msg = "Email not found or password update failed.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Reset Password</title>
  <style>
    body {
      font-family: Arial;
      background: #f4f4f4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .box {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px #ccc;
      width: 300px;
    }
    input, button {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
    }
    .msg {
      color: green;
      text-align: center;
    }
    .error {
      color: red;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="box">
    <h2>Reset Password</h2>
    <form method="post">
      <input type="email" name="email" placeholder="Enter your admin email" required />
      <input type="password" name="new_password" placeholder="New Password" required />
      <button type="submit">Reset Password</button>
    </form>
    <div class="<?= strpos($msg, 'successfully') !== false ? 'msg' : 'error' ?>">
      <?= $msg ?>
    </div>
  </div>
</body>
</html>
