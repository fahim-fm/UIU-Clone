<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header('Location: admin_login.php'); exit(); }
include 'db_connect.php';
$msg  = '';
$type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = $conn->real_escape_string(trim($_POST['title'] ?? ''));
    $date    = $conn->real_escape_string($_POST['date'] ?? '');
    $pdfFile = null;

    if (!empty($_FILES['pdf_file']['name']) && $_FILES['pdf_file']['error'] === 0) {
        $ext = strtolower(pathinfo($_FILES['pdf_file']['name'], PATHINFO_EXTENSION));
        if ($ext === 'pdf') {
            $uploadDir = 'uploads/notices/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $dest = $uploadDir . time() . '_' . basename($_FILES['pdf_file']['name']);
            if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $dest)) {
                $pdfFile = $dest;
            } else { $msg = '❌ Error uploading PDF.'; $type = 'error'; }
        } else { $msg = '⚠️ Only PDF files allowed.'; $type = 'error'; }
    }

    if (empty($msg)) {
        if ($title && $date) {
            $pdfVal = $pdfFile ? "'". $conn->real_escape_string($pdfFile) ."'" : 'NULL';
            $conn->query("INSERT INTO notices (title, date, pdf_file) VALUES ('$title','$date',$pdfVal)");
            $msg = '✅ Notice added successfully!'; $type = 'success';
        } else { $msg = '⚠️ Please fill in all fields.'; $type = 'error'; }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Notice – UIU Admin</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
  <link rel="stylesheet" href="admin-table.css">
</head>
<body>
<div class="admin-wrap">
  <h2>📢 Add New Notice</h2>
  <div class="form-container">
    <?php if ($msg): ?><div class="form-msg <?= $type ?>"><?= $msg ?></div><?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
      <label>Notice Title:</label>
      <input type="text" name="title" placeholder="Enter notice title" required>
      <label>Date:</label>
      <input type="date" name="date" required>
      <label>Upload PDF (optional):</label>
      <input type="file" name="pdf_file" accept=".pdf">
      <button type="submit" class="btn btn-submit">Add Notice</button>
    </form>
    <div class="back-row" style="margin-top:14px;">
      <a href="admin_dashboard.php" class="btn btn-back">⬅ Back to Dashboard</a>
    </div>
  </div>
</div>
</body>
</html>
