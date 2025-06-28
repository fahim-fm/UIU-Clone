<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: admin_login.php");
  exit();
}

include 'db_connect.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $date = $conn->real_escape_string($_POST['date']);
    $pdfFile = null;

    if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] == 0) {
        $uploadDir = "uploads/";
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $pdfFileName = basename($_FILES["pdf_file"]["name"]);
        $targetFilePath = $uploadDir . time() . "_" . $pdfFileName;

        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        if ($fileType == "pdf") {
            if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $targetFilePath)) {
                $pdfFile = $targetFilePath;
            } else {
                $message = "❌ Error uploading the PDF.";
            }
        } else {
            $message = "⚠️ Only PDF files are allowed.";
        }
    }

    if (!empty($title) && !empty($date)) {
        $sql = "INSERT INTO notices (title, date, pdf_file) VALUES ('$title', '$date', " . ($pdfFile ? "'$pdfFile'" : "NULL") . ")";
        if ($conn->query($sql)) {
            $message = "✅ Notice added successfully!";
        } else {
            $message = "❌ Error: " . $conn->error;
        }
    } else {
        $message = "⚠️ Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Notice</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .form-container {
      max-width: 500px;
      margin: 40px auto;
      padding: 30px;
      border: 1px solid #ddd;
      border-radius: 10px;
      background: #f9f9f9;
    }
    .form-container h2 {
      margin-bottom: 20px;
      text-align: center;
    }
    .form-container input, .form-container button {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      border-radius: 5px;
      border: 1px solid #aaa;
    }
    .message {
      margin-top: 15px;
      color: green;
      font-weight: bold;
      text-align: center;
    }
  </style>
</head>
<body>

<div class="form-container">
  <h2>Add New Notice</h2>
  <form method="POST" enctype="multipart/form-data">
    <label>Notice Title:</label>
    <input type="text" name="title" required>

    <label>Date:</label>
    <input type="date" name="date" required>

    <label>Upload PDF (optional):</label>
    <input type="file" name="pdf_file" accept=".pdf">

    <button type="submit">Add Notice</button>
  </form>
  <a href="admin_dashboard.php">
    <button style="margin-top: 15px; background-color: #28a745;">Back to Dashboard</button>
  </a>

  <?php if (!empty($message)): ?>
    <p class="message"><?= $message ?></p>
  <?php endif; ?>
</div>

</body>
</html>

<?php $conn->close(); ?>
