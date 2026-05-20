<?php
session_start();
if (!isset($_SESSION['student'])) {
    header('Location: student_auth.php');
    exit();
}
$student = $_SESSION['student'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Dashboard – UIU</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
  <link rel="stylesheet" href="style.css">
</head>
<body class="glass-page">

  <div class="home-link"><a href="index.php">&#8592; Back to Home</a></div>

  <div class="dashboard">
    <?php if (!empty($student['profile_pic'])): ?>
      <img src="<?= htmlspecialchars($student['profile_pic']) ?>" alt="Profile Picture">
    <?php else: ?>
      <img src="uploads/profile_pics/default.png" alt="Default Profile">
    <?php endif; ?>

    <h2><?= htmlspecialchars($student['fullname']) ?></h2>
    <p><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></p>
    <p><strong>Department:</strong> <?= htmlspecialchars($student['department']) ?></p>
    <p><strong>Level:</strong> <?= htmlspecialchars($student['level']) ?></p>
    <p><strong>Registered On:</strong> <?= htmlspecialchars($student['created_at']) ?></p>

    <a href="student_edit.php" class="edit-btn">&#9998; Edit Profile</a>
    <a href="logout.php"       class="logout-link">Logout</a>
  </div>

</body>
</html>
