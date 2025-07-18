<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: admin_login.php");
  exit();
}

include 'db_connect.php';

$id = intval($_GET['id']);
$notice = $conn->query("SELECT * FROM notices WHERE id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $title = $conn->real_escape_string($_POST["title"]);
  $date = $conn->real_escape_string($_POST["date"]);

  // If a new PDF is uploaded
  if (!empty($_FILES["pdf_file"]["name"])) {
    $uploadDir = "uploads/";
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $new_pdf = $uploadDir . time() . "_" . basename($_FILES["pdf_file"]["name"]);
    
    if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $new_pdf)) {
      // Delete old PDF
      if (!empty($notice['pdf_file']) && file_exists($notice['pdf_file'])) {
        unlink($notice['pdf_file']);
      }
      $conn->query("UPDATE notices SET title='$title', date='$date', pdf_file='$new_pdf' WHERE id=$id");
    }
  } else {
    $conn->query("UPDATE notices SET title='$title', date='$date' WHERE id=$id");
  }

  header("Location: manage_notices.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Notice</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .form-container {
      max-width: 500px;
      margin: 40px auto;
      background: #f9f9f9;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 0 10px #ccc;
    }
    .form-container input, .form-container textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .form-container button {
      background: #007bff;
      color: #fff;
      padding: 10px;
      width: 100%;
      border: none;
      border-radius: 5px;
    }
  </style>
</head>
<body>

<div class="form-container">
  <h2>Edit Notice</h2>
  <form method="post" enctype="multipart/form-data">
    <label>Notice Title:</label>
    <input type="text" name="title" value="<?= htmlspecialchars($notice['title']) ?>" required>

    <label>Date:</label>
    <input type="date" name="date" value="<?= $notice['date'] ?>" required>

    <?php if (!empty($notice['pdf_file'])): ?>
      <p>Current PDF: <a href="<?= $notice['pdf_file'] ?>" target="_blank">📄 View PDF</a></p>
    <?php endif; ?>

    <label>Upload New PDF (optional)</label>
    <input type="file" name="pdf_file" accept=".pdf">
    
    <button type="submit">Update Notice</button>
  </form>
  <a href="manage_notices.php" style="display:block;margin-top:10px;text-align:center;">⬅ Back to Manage Notices</a>
</div>

</body>
</html>
