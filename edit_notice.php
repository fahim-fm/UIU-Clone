<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header('Location: admin_login.php'); exit(); }
include 'db_connect.php';

$id = (int)($_GET['id'] ?? 0);
$res = $conn->query("SELECT * FROM notices WHERE id=$id");
if (!$res || $res->num_rows === 0) { die('Notice not found.'); }
$notice = $res->fetch_assoc();

$msg  = '';
$type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = $conn->real_escape_string(trim($_POST['title'] ?? ''));
    $date    = $conn->real_escape_string($_POST['date'] ?? '');
    $pdfFile = $notice['pdf_file'];

    if (!empty($_FILES['pdf_file']['name']) && $_FILES['pdf_file']['error'] === 0) {
        $ext = strtolower(pathinfo($_FILES['pdf_file']['name'], PATHINFO_EXTENSION));
        if ($ext === 'pdf') {
            $uploadDir = 'uploads/notices/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $dest = $uploadDir . time() . '_' . basename($_FILES['pdf_file']['name']);
            if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $dest)) {
                // Remove old file
                if (!empty($pdfFile) && file_exists($pdfFile)) unlink($pdfFile);
                $pdfFile = $dest;
            } else { $msg = '❌ Upload failed.'; $type = 'error'; }
        } else { $msg = '⚠️ Only PDF allowed.'; $type = 'error'; }
    }

    if (empty($msg) && $title && $date) {
        $pf = $conn->real_escape_string($pdfFile ?? '');
        $conn->query("UPDATE notices SET title='$title', date='$date', pdf_file=" . ($pf ? "'$pf'" : 'NULL') . " WHERE id=$id");
        $notice['title'] = $title; $notice['date'] = $date;
        $msg = '✅ Notice updated!'; $type = 'success';
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
  <title>Edit Notice – UIU Admin</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
  <link rel="stylesheet" href="admin-table.css">
</head>
<body>
<div class="admin-wrap">
  <h2>✏️ Edit Notice</h2>
  <div class="form-container">
    <?php if ($msg): ?><div class="form-msg <?= $type ?>"><?= $msg ?></div><?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
      <label>Notice Title:</label>
      <input type="text" name="title" value="<?= htmlspecialchars($notice['title']) ?>" required>
      <label>Date:</label>
      <input type="date" name="date"  value="<?= htmlspecialchars($notice['date']) ?>"  required>
      <?php if (!empty($notice['pdf_file'])): ?>
        <p style="margin-bottom:10px">Current PDF: <a href="<?= htmlspecialchars($notice['pdf_file']) ?>" target="_blank">📄 View</a></p>
      <?php endif; ?>
      <label>Replace PDF (optional):</label>
      <input type="file" name="pdf_file" accept=".pdf">
      <button type="submit" class="btn btn-submit">Update Notice</button>
    </form>
    <div class="back-row" style="margin-top:14px;">
      <a href="manage_notices.php" class="btn btn-back">⬅ Back to Notices</a>
    </div>
  </div>
</div>
</body>
</html>
