<?php
session_start();
include 'db_connect.php';

$msg = "";

// ✅ Student Registration
if (isset($_POST['register'])) {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $email = $conn->real_escape_string($_POST['email']);
    $department = $conn->real_escape_string($_POST['department']);
    $level = $conn->real_escape_string($_POST['level']);
    $password = md5($_POST['password']); // simple hash

    $checkEmail = $conn->query("SELECT * FROM students WHERE email='$email'");
    if ($checkEmail->num_rows > 0) {
        $msg = "⚠ Email already registered!";
    } else {
        $sql = "INSERT INTO students (fullname, email, department, level, password)
                VALUES ('$fullname','$email','$department','$level','$password')";
        if ($conn->query($sql)) {
            $msg = "✅ Registration successful! Please login.";
        } else {
            $msg = "❌ Error: ".$conn->error;
        }
    }
}

// ✅ Student Login
if (isset($_POST['login'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = md5($_POST['password']);

    $result = $conn->query("SELECT * FROM students WHERE email='$email' AND password='$password'");
    if ($result->num_rows == 1) {
        $student = $result->fetch_assoc();
        $_SESSION['student'] = $student;
        header("Location: student_dashboard.php");
        exit();
    } else {
        $msg = "❌ Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Login / Register</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Inter',sans-serif;
        }
        body{
            background:url('image/BC4.jpg') no-repeat center center fixed;
            background-size:cover;
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }
        .container{
            width:400px;
            background:rgba(255,255,255,0.15);
            backdrop-filter:blur(15px);
            padding:30px;
            border-radius:18px;
            box-shadow:0 8px 25px rgba(0,0,0,0.2);
            animation:fadeIn 0.8s ease-in-out;
            color:#fff;
        }
        h2{
            text-align:center;
            margin-bottom:20px;
            font-size:26px;
            letter-spacing:1px;
        }
        input, select{
            width:100%;
            padding:12px;
            margin:10px 0;
            border:none;
            border-radius:10px;
            background:rgba(255,255,255,0.2);
            color:#fff;
            font-size:15px;
            outline:none;
        }
        input::placeholder{
            color:#ddd;
        }
        select option{
            color:#000;
        }
        button{
            width:100%;
            padding:12px;
            margin-top:10px;
            border:none;
            border-radius:10px;
            background:linear-gradient(135deg,#6a11cb,#2575fc);
            color:#fff;
            font-size:16px;
            font-weight:600;
            cursor:pointer;
            transition:transform 0.3s ease,box-shadow 0.3s ease;
        }
        button:hover{
            transform:translateY(-3px);
            box-shadow:0 5px 15px rgba(0,0,0,0.2);
        }
        .toggle-link{
            text-align:center;
            margin-top:12px;
        }
        .toggle-link a{
            color:#f0f0f0;
            text-decoration:none;
            font-size:14px;
            transition:color 0.3s ease;
        }
        .toggle-link a:hover{
            color:#ffdede;
        }
        .message{
            text-align:center;
            background:rgba(0,0,0,0.3);
            padding:8px;
            margin-bottom:10px;
            border-radius:8px;
            font-size:14px;
        }
        @keyframes fadeIn{
            from{opacity:0; transform:translateY(-20px);}
            to{opacity:1; transform:translateY(0);}
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
    <script>
        function toggleForms() {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const title = document.getElementById('form-title');

            if (loginForm.style.display === 'none') {
                loginForm.style.display = 'block';
                registerForm.style.display = 'none';
                title.innerText = 'Student Login';
            } else {
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
                title.innerText = 'Student Registration';
            }
        }
    </script>
</head>
<body>
  <div class="back-home">
    <a href="index.php">⬅ Back to Home</a>
  </div>

<div class="container">
    <h2 id="form-title">Student Login</h2>

    <?php if(!empty($msg)) echo "<p class='message'>$msg</p>"; ?>

    <!-- ✅ Login Form -->
    <form id="login-form" method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
        <div class="toggle-link">
            <a href="#" onclick="toggleForms();return false;">New Student? Register</a>
        </div>
    </form>

    <!-- ✅ Register Form -->
    <form id="register-form" method="post" style="display:none;">
        <input type="text" name="fullname" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
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
