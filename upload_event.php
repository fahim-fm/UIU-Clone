<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: admin_login.php");
  exit();
}

include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $title = $_POST["title"];
  $desc = $_POST["description"];
  $date = $_POST["date"];
  $image = "";

  if ($_FILES["image"]["name"]) {
    $target_dir = "image/uploaded_event/";
    $image = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $image);
  }

  $sql = "INSERT INTO events (title, description, date, image) VALUES ('$title', '$desc', '$date', '$image')";
  $conn->query($sql);
  //header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Event</title>
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

    .form-container h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .form-container input[type="text"],
    .form-container input[type="date"],
    .form-container textarea,
    .form-container input[type="file"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .form-container button {
      background-color: #0066cc;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      width: 100%;
      font-size: 16px;
      cursor: pointer;
    }

    .form-container button:hover {
      background-color: #004999;
    }
  </style>
</head>
<body>

<div class="form-container">
  <h2>Add New Event</h2>
  <form action="upload_event.php" method="post" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Event Title" required>
    <textarea name="description" placeholder="Description" rows="4"></textarea>
    <input type="date" name="date" required>
    <input type="file" name="image">
    <button type="submit">Add Event</button>
  </form>
  <a href="admin_dashboard.php">
  <button style="margin-top: 15px; background-color: #28a745;">Back to Dashboard</button>
</a>

</div>

</body>
</html>
