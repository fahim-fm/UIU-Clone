<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header('Location: admin_login.php'); exit(); }
include 'db_connect.php';
$msg  = '';
$type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string(trim($_POST['title']       ?? ''));
    $desc  = $conn->real_escape_string(trim($_POST['description'] ?? ''));
    $date  = $conn->real_escape_string($_POST['date']             ?? '');
    $image = '';

    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === 0) {
        $allowed = ['jpg','jpeg','png','gif','webp'];
        $ext     = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed, true)) {
            $uploadDir = 'image/uploaded_event/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $dest = $uploadDir . time() . '_' . basename($_FILES['image']['name']);
            if (move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
                $image = $dest;
            } else { $msg = '❌ Error uploading image.'; $type = 'error'; }
        } else { $msg = '⚠️ Only JPG, PNG, GIF, WEBP allowed.'; $type = 'error'; }
    }

    if (empty($msg) && $title && $date) {
        $img = $conn->real_escape_string($image);
        $conn->query("INSERT INTO events (title, description, date, image) VALUES ('$title','$desc','$date','$img')");
        $msg = '✅ Event added successfully!'; $type = 'success';
    } elseif (empty($msg)) {
        $msg = '⚠️ Title and date are required.'; $type = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Event – UIU Admin</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
  <link rel="stylesheet" href="admin-table.css">
</head>
<body>
<div class="admin-wrap">
  <h2>📅 Add New Event</h2>
  <div class="form-container">
    <?php if ($msg): ?><div class="form-msg <?= $type ?>"><?= $msg ?></div><?php endif; ?>
    <form method="POST" enctype="multipart/form-data" action="upload_event.php">
      <label>Event Title:</label>
      <input type="text" name="title" placeholder="Event title" required>
      <label>Description:</label>
      <textarea name="description" rows="4" placeholder="Event description..."></textarea>
      <label>Date:</label>
      <input type="date" name="date" required>
      <label>Image (optional):</label>
      <input type="file" name="image" accept="image/*">
      <button type="submit" class="btn btn-submit">Add Event</button>
    </form>
    <div class="back-row" style="margin-top:14px;">
      <a href="admin_dashboard.php" class="btn btn-back">⬅ Back to Dashboard</a>
    </div>
  </div>
</div>
</body>
</html>
