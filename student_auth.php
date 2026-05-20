<?php
session_start();
include 'db_connect.php';
$msg = '';

// Registration
if (isset($_POST['register'])) {
    $fullname   = $conn->real_escape_string(trim($_POST['fullname']   ?? ''));
    $email      = $conn->real_escape_string(trim($_POST['email']      ?? ''));
    $department = $conn->real_escape_string($_POST['department']      ?? '');
    $level      = $conn->real_escape_string($_POST['level']           ?? '');
    $password   = md5($_POST['password'] ?? '');

    $check = $conn->query("SELECT id FROM students WHERE email='$email'");
    if ($check && $check->num_rows > 0) {
        $msg = '&#9888; Email already registered!';
    } else {
        $sql = "INSERT INTO students (fullname, email, department, level, password)
                VALUES ('$fullname','$email','$department','$level','$password')";
        $msg = $conn->query($sql)
            ? '&#10003; Registration successful! Please login.'
            : '&#10007; Error: ' . htmlspecialchars($conn->error);
    }
}

// Login
if (isset($_POST['login'])) {
    $email    = $conn->real_escape_string(trim($_POST['email']    ?? ''));
    $password = md5($_POST['password'] ?? '');

    $result = $conn->query("SELECT * FROM students WHERE email='$email' AND password='$password'");
    if ($result && $result->num_rows === 1) {
        $_SESSION['student'] = $result->fetch_assoc();
        header('Location: student_dashboard.php');
        exit();
    } else {
        $msg = '&#10007; Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Login – UIU</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
  <link rel="stylesheet" href="style.css">
  <script>
    function toggleForms() {
      var lf = document.getElementById('login-form');
      var rf = document.getElementById('register-form');
      var title = document.getElementById('form-title');
      if (lf.style.display === 'none') {
        lf.style.display = 'block'; rf.style.display = 'none';
        title.textContent = 'Student Login';
      } else {
        lf.style.display = 'none'; rf.style.display = 'block';
        title.textContent = 'Student Registration';
      }
    }
  </script>
</head>
<body class="glass-page">
  <div class="back-home"><a href="index.php">&#8592; Back to Home</a></div>

  <div class="glass-box">
    <h2 id="form-title">Student Login</h2>

    <?php if ($msg): ?>
      <div class="message"><?= $msg ?></div>
    <?php endif; ?>

    <!-- Login Form -->
    <form id="login-form" method="post" action="">
      <input type="email"    name="email"    placeholder="Email"    required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" name="login">Login</button>
      <div class="toggle-link">
        <a href="#" onclick="toggleForms();return false;">New Student? Register</a>
      </div>
    </form>

    <!-- Register Form -->
    <form id="register-form" method="post" action="" style="display:none">
      <input type="text"     name="fullname"   placeholder="Full Name"  required>
      <input type="email"    name="email"      placeholder="Email"      required>
      <select name="department" required>
        <option value="">Select Department</option>
        <option>CSE</option>
        <option>EEE</option>
        <option>Business</option>
        <option>Civil</option>
      </select>
      <select name="level" required>
        <option value="">Select Level</option>
        <option>Undergraduate</option>
        <option>Masters</option>
      </select>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" name="register">Register</button>
      <div class="toggle-link">
        <a href="#" onclick="toggleForms();return false;">Already registered? Login</a>
      </div>
    </form>
  </div>
</body>
</html>
