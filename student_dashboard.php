<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['student'])) {
  header("Location: student_auth.php");
  exit;
}

$student = $_SESSION['student'];
$student_id = $student['id'];

// Update profile info
if (isset($_POST['update_profile'])) {
  $name = $_POST['name'];
  $department = $_POST['department'];
  $level = $_POST['level'];

  $conn->query("UPDATE students SET name='$name', department='$department', level='$level' WHERE id=$student_id");

  $_SESSION['student']['name'] = $name;
  $_SESSION['student']['department'] = $department;
  $_SESSION['student']['level'] = $level;

  header("Location: student_dashboard.php");
  exit;
}

// Upload profile picture
if (isset($_POST['upload_pic'])) {
  if ($_FILES['profile_pic']['error'] === 0) {
    $file = $_FILES['profile_pic'];
    $filename = time() . '_' . basename($file['name']);
    $target = 'uploads/' . $filename;

    if (move_uploaded_file($file['tmp_name'], $target)) {
      $conn->query("UPDATE students SET profile_pic='$filename' WHERE id=$student_id");
      $_SESSION['student']['profile_pic'] = $filename;
    }
  }
  header("Location: student_dashboard.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Student Dashboard</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: rgba(88, 103, 138, 0.8);
      margin: 0;
      padding: 20px;
    }
    .dashboard-container {
      max-width: 900px;
      background: #ffffff;
      margin: auto;
      padding: 30px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      border-radius: 12px;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }
    .profile-section {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      margin-bottom: 30px;
      position: relative;
    }
    .profile-pic-wrapper {
      position: relative;
      display: inline-block;
    }
    .profile-pic-wrapper img {
      width: 110px;
      height: 110px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #007bff;
      cursor: pointer;
      transition: opacity 0.3s ease;
    }
    .profile-pic-wrapper img:hover {
      opacity: 0.8;
    }
    .corner-icon {
      position: absolute;
      bottom: 5px;
      right: 5px;
      background-color: white;
      border-radius: 50%;
      padding: 4px;
      box-shadow: 0 0 4px rgba(0,0,0,0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      pointer-events: none; /* lets clicks pass to image */
    }

    form {
      margin: 20px 0;
    }
    label {
      font-weight: 600;
      display: block;
      margin-bottom: 5px;
      color: #444;
    }
    input[type="text"], input[type="file"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
    }
    button {
      padding: 10px 20px;
      background: #007bff;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 15px;
      cursor: pointer;
    }
    button:hover {
      background: #0056b3;
    }
    .logout {
      text-align: center;
      margin-top: 30px;
    }
    .logout button {
      background-color: #dc3545;
    }
    .section-title {
      font-size: 18px;
      margin-top: 30px;
      margin-bottom: 10px;
      color: #222;
      border-bottom: 1px solid #ddd;
      padding-bottom: 5px;
    }

    /* Hamburger menu styles */
    #hamburger-menu {
      position: fixed;
      top: 34px;
      left: 250px;
      z-index: 1000;
      user-select: none;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .hamburger {
      width: 30px;
      height: 22px;
      cursor: pointer;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .hamburger div {
      height: 4px;
      background-color:rgb(255, 0, 43);
      border-radius: 2px;
    }
    #menu-options {
      margin-top: 10px;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      width: 150px;
      overflow: hidden;
      transition: max-height 0.3s ease, opacity 0.3s ease;
    }
    #menu-options.hidden {
      max-height: 0;
      padding: 0;
      opacity: 0;
      pointer-events: none;
    }
    #menu-options a {
      display: block;
      padding: 12px 15px;
      text-decoration: none;
      color: #007bff;
      font-weight: 600;
      border-bottom: 1px solid #eee;
    }
    #menu-options a:last-child {
      border-bottom: none;
    }
    #menu-options a:hover {
      background-color: #f0f4ff;
    }
  </style>
</head>
<body>

  <!-- Hamburger Menu -->
  <div id="hamburger-menu">
    <div class="hamburger" onclick="toggleMenu()">
      <div></div>
      <div></div>
      <div></div>
    </div>
    <div id="menu-options" class="hidden">
      <a href="notices.php">View Notices</a>
      <a href="apply_online.php">Apply Online</a>
      <a href="contact.php">Contact Us</a>
    </div>
  </div>

  <div class="dashboard-container">
    <h2> <?= htmlspecialchars($student['name']) ?></h2>

    <!-- Clickable Profile Picture with Camera Icon in Corner -->
    <div class="profile-section">
      <form method="post" enctype="multipart/form-data" id="picForm" style="position: relative; display: inline-block;">
        <input type="file" name="profile_pic" id="profileInput" accept="image/*" style="display:none" onchange="document.getElementById('picForm').submit();">

        <label for="profileInput" title="Click to change profile picture" class="profile-pic-wrapper">
          <?php if (!empty($student['profile_pic'])): ?>
            <img src="uploads/<?= htmlspecialchars($student['profile_pic']) ?>" alt="Profile Picture" />
          <?php else: ?>
            <img src="https://www.w3schools.com/howto/img_avatar.png" alt="Default Picture" />
          <?php endif; ?>

          <!-- Camera icon inside the corner -->
          <div class="corner-icon">
            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" fill="#007bff" viewBox="0 0 24 24">
              <path d="M12 5.5c-3.58 0-6.5 2.92-6.5 6.5S8.42 18.5 12 18.5s6.5-2.92 6.5-6.5S15.58 5.5 12 5.5zm0 11c-2.48 0-4.5-2.02-4.5-4.5S9.52 7.5 12 7.5s4.5 2.02 4.5 4.5-2.02 4.5-4.5 4.5z"/>
              <circle cx="12" cy="12" r="2"/>
              <path d="M20 4h-3.17l-1.84-2H8.99L7.15 4H4c-1.1 0-1.99.9-1.99 2L2 20c0 1.1.89 2 1.99 2H20c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z"/>
            </svg>
          </div>
        </label>
      </form>
      <p><small>Click the image to change your profile picture</small></p>
    </div>

    <!-- Update Profile Info -->
    <div>
      <div class="section-title">Update Profile Information</div>
      <form method="post">
        <label for="name">Full Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required />

        <label for="department">Department:</label>
        <input type="text" name="department" value="<?= htmlspecialchars($student['department'] ?? '') ?>" />

        <label for="level">Level:</label>
        <input type="text" name="level" value="<?= htmlspecialchars($student['level'] ?? '') ?>" />

        <button type="submit" name="update_profile">Update Info</button>
      </form>
    </div>

    <!-- Logout -->
    <div class="logout">
      <a href="student_auth.php?logout=1">
        <button>Logout</button>
      </a>
    </div>
  </div>

  <script>
    function toggleMenu() {
      const menu = document.getElementById('menu-options');
      if (menu.classList.contains('hidden')) {
        menu.classList.remove('hidden');
      } else {
        menu.classList.add('hidden');
      }
    }

    // Close menu if clicked outside
    document.addEventListener('click', function(event) {
      const menu = document.getElementById('menu-options');
      const hamburger = document.querySelector('.hamburger');
      if (!hamburger.contains(event.target) && !menu.contains(event.target)) {
        menu.classList.add('hidden');
      }
    });
  </script>

</body>
</html>
