<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['student'])) {
    header('Location: student_auth.php');
    exit();
}

$student = $_SESSION['student'];
$id      = (int)$student['id'];
$msg     = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname   = $conn->real_escape_string(trim($_POST['fullname']   ?? ''));
    $department = $conn->real_escape_string($_POST['department']      ?? '');
    $level      = $conn->real_escape_string($_POST['level']           ?? '');
    $profile_pic = $student['profile_pic'];

    if (!empty($_FILES['profile_pic']['name'])) {
        $uploadDir = 'uploads/profile_pics/';
        if (!is_dir($uploadDir)) { mkdir($uploadDir, 0755, true); }

        $allowed = ['jpg','jpeg','png','gif','webp'];
        $ext     = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed, true)) {
            $fileName   = time() . '_' . basename($_FILES['profile_pic']['name']);
            $targetPath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetPath)) {
                $profile_pic = $targetPath;
            } else {
                $msg = '&#9888; Error uploading image!';
            }
        } else {
            $msg = '&#9888; Only JPG, PNG, GIF, WEBP allowed!';
        }
    }

    if (empty($msg)) {
        $pp = $conn->real_escape_string($profile_pic);
        $conn->query("UPDATE students SET fullname='$fullname', department='$department', level='$level', profile_pic='$pp' WHERE id=$id");
        $_SESSION['student']['fullname']    = $fullname;
        $_SESSION['student']['department']  = $department;
        $_SESSION['student']['level']       = $level;
        $_SESSION['student']['profile_pic'] = $profile_pic;
        $student = $_SESSION['student'];
        $msg = '&#10003; Profile updated!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile – UIU</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
  <link rel="stylesheet" href="style.css">
</head>
<body class="glass-page">

  <div class="form-box">
    <h2>&#9998; Edit Profile</h2>
    <?php if ($msg): ?><p class="msg"><?= $msg ?></p><?php endif; ?>

    <?php if (!empty($student['profile_pic'])): ?>
      <img src="<?= htmlspecialchars($student['profile_pic']) ?>" alt="Profile Picture">
    <?php else: ?>
      <img src="uploads/profile_pics/default.png" alt="Default">
    <?php endif; ?>

    <form method="post" action="" enctype="multipart/form-data">
      <label>Full Name:</label>
      <input type="text" name="fullname" value="<?= htmlspecialchars($student['fullname']) ?>" required>

      <label>Department:</label>
      <select name="department" required>
        <?php foreach (['CSE','EEE','Business','Civil'] as $dept): ?>
          <option <?= $student['department'] === $dept ? 'selected' : '' ?>><?= $dept ?></option>
        <?php endforeach; ?>
      </select>

      <label>Level:</label>
      <select name="level" required>
        <?php foreach (['Undergraduate','Masters'] as $lvl): ?>
          <option <?= $student['level'] === $lvl ? 'selected' : '' ?>><?= $lvl ?></option>
        <?php endforeach; ?>
      </select>

      <label>Profile Picture:</label>
      <input type="file" name="profile_pic" accept="image/*">

      <button type="submit">&#10003; Update Profile</button>
    </form>
    <a href="student_dashboard.php" class="back-link">&#8592; Back to Dashboard</a>
  </div>

</body>
</html>
