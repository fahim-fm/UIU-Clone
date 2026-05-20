<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header('Location: admin_login.php'); exit(); }
include 'db_connect.php';

$id  = (int)($_GET['id'] ?? 0);
$res = $conn->query("SELECT * FROM events WHERE id=$id");
if (!$res || $res->num_rows === 0) { die('Event not found.'); }
$event = $res->fetch_assoc();

$msg  = '';
$type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string(trim($_POST['title']       ?? ''));
    $desc  = $conn->real_escape_string(trim($_POST['description'] ?? ''));
    $date  = $conn->real_escape_string($_POST['date']             ?? '');
    $image = $event['image'];

    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === 0) {
        $allowed = ['jpg','jpeg','png','gif','webp'];
        $ext     = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed, true)) {
            $dir  = 'image/uploaded_event/';
            if (!is_dir($dir)) mkdir($dir, 0755, true);
            $dest = $dir . time() . '_' . basename($_FILES['image']['name']);
            if (move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
                if (!empty($image) && file_exists($image)) unlink($image);
                $image = $dest;
            } else { $msg = '❌ Upload failed.'; $type = 'error'; }
        } else { $msg = '⚠️ Only JPG/PNG/GIF/WEBP allowed.'; $type = 'error'; }
    }

    if (empty($msg) && $title && $date) {
        $img = $conn->real_escape_string($image);
        $conn->query("UPDATE events SET title='$title', description='$desc', date='$date', image='$img' WHERE id=$id");
        $event = array_merge($event, ['title'=>$title,'description'=>$_POST['description'],'date'=>$date,'image'=>$image]);
        $msg = '✅ Event updated!'; $type = 'success';
    } elseif (empty($msg)) {
        $msg = '⚠️ Title and date required.'; $type = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Event – UIU Admin</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
  <link rel="stylesheet" href="admin-table.css">
</head>
<body>
<div class="admin-wrap">
  <h2>✏️ Edit Event</h2>
  <div class="form-container">
    <?php if ($msg): ?><div class="form-msg <?= $type ?>"><?= $msg ?></div><?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
      <label>Event Title:</label>
      <input type="text" name="title" value="<?= htmlspecialchars($event['title']) ?>" required>
      <label>Description:</label>
      <textarea name="description" rows="4"><?= htmlspecialchars($event['description']) ?></textarea>
      <label>Date:</label>
      <input type="date" name="date" value="<?= htmlspecialchars($event['date']) ?>" required>
      <?php if (!empty($event['image'])): ?>
        <p style="margin-bottom:8px">Current image:</p>
        <img src="<?= htmlspecialchars($event['image']) ?>" class="thumb" alt="current" style="width:80px;height:80px;border-radius:6px;margin-bottom:12px">
      <?php endif; ?>
      <label>Replace Image (optional):</label>
      <input type="file" name="image" accept="image/*">
      <button type="submit" class="btn btn-submit">Update Event</button>
    </form>
    <div class="back-row" style="margin-top:14px;">
      <a href="manage_events.php" class="btn btn-back">⬅ Back to Events</a>
    </div>
  </div>
</div>
</body>
</html>
