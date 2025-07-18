<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: admin_login.php");
  exit();
}

include 'db_connect.php';

$id = intval($_GET['id']);
$event = $conn->query("SELECT * FROM events WHERE id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $title = $_POST["title"];
  $desc = $_POST["description"];
  $date = $_POST["date"];
  
  // If a new image is uploaded
  if (!empty($_FILES["image"]["name"])) {
    $target_dir = "image/uploaded_event/";
    $new_image = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $new_image);

    // Delete old image
    if (!empty($event['image']) && file_exists($event['image'])) {
      unlink($event['image']);
    }

    $conn->query("UPDATE events SET title='$title', description='$desc', date='$date', image='$new_image' WHERE id=$id");
  } else {
    $conn->query("UPDATE events SET title='$title', description='$desc', date='$date' WHERE id=$id");
  }

  header("Location: manage_events.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Event</title>
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
  <h2>Edit Event</h2>
  <form method="post" enctype="multipart/form-data">
    <input type="text" name="title" value="<?= htmlspecialchars($event['title']) ?>" required>
    <textarea name="description" rows="4"><?= htmlspecialchars($event['description']) ?></textarea>
    <input type="date" name="date" value="<?= $event['date'] ?>" required>
    
    <?php if (!empty($event['image'])): ?>
      <p>Current Image:</p>
      <img src="<?= $event['image'] ?>" width="100"><br>
    <?php endif; ?>
    
    <label>Upload New Image (optional)</label>
    <input type="file" name="image">
    
    <button type="submit">Update Event</button>
  </form>
  <a href="manage_events.php" style="display:block;margin-top:10px;text-align:center;">⬅ Back to Manage Events</a>
</div>
</body>
</html>
