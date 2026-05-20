<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header('Location: admin_login.php'); exit(); }
include 'db_connect.php';

$id  = (int)($_GET['id'] ?? 0);
$res = $conn->query("SELECT * FROM students WHERE id=$id");
if (!$res || $res->num_rows === 0) { die('Student not found.'); }
$student = $res->fetch_assoc();

$msg  = '';
$type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname   = $conn->real_escape_string(trim($_POST['fullname']   ?? ''));
    $department = $conn->real_escape_string($_POST['department']      ?? '');
    $level      = $conn->real_escape_string($_POST['level']           ?? '');

    $conn->query("UPDATE students SET fullname='$fullname', department='$department', level='$level' WHERE id=$id");
    $student['fullname']   = $fullname;
    $student['department'] = $department;
    $student['level']      = $level;
    $msg  = '✅ Student updated successfully!';
    $type = 'success';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Student – UIU Admin</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
  <link rel="stylesheet" href="admin-table.css">
</head>
<body class="page-center">
  <div class="edit-form-box">
    <h2>✏️ Edit Student</h2>
    <?php if ($msg): ?><div class="msg"><?= $msg ?></div><?php endif; ?>
    <form method="POST">
      <label>Full Name</label>
      <input type="text" name="fullname" value="<?= htmlspecialchars($student['fullname']) ?>" required>

      <label>Department</label>
      <select name="department" required>
        <?php foreach (['CSE','EEE','Business','Civil'] as $d): ?>
          <option <?= $student['department'] === $d ? 'selected' : '' ?>><?= $d ?></option>
        <?php endforeach; ?>
      </select>

      <label>Level</label>
      <select name="level" required>
        <?php foreach (['Undergraduate','Masters'] as $l): ?>
          <option <?= $student['level'] === $l ? 'selected' : '' ?>><?= $l ?></option>
        <?php endforeach; ?>
      </select>

      <button type="submit">Update Student</button>
    </form>
    <a href="manage_students.php" class="back-link">⬅ Back to Students</a>
  </div>
</body>
</html>
