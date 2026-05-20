<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard – UIU</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body class="glass-page">

  <div class="glass-box" style="width:min(500px,92vw)">
    <h2>&#9889; Admin Dashboard</h2>
    <nav class="admin-nav">
      <a href="add_notice.php"><i class="fa-solid fa-plus"></i> Add Notice</a>
      <a href="upload_event.php"><i class="fa-solid fa-calendar-plus"></i> Add Event</a>
      <a href="view_messages.php"><i class="fa-solid fa-envelope-open-text"></i> View Messages</a>
      <a href="view_applications.php"><i class="fa-solid fa-file-lines"></i> View Applications</a>
      <a href="manage_events.php"><i class="fa-solid fa-calendar-days"></i> Manage Events</a>
      <a href="manage_notices.php"><i class="fa-solid fa-bullhorn"></i> Manage Notices</a>
      <a href="manage_students.php"><i class="fa-solid fa-users"></i> Manage Students</a>
    </nav>
    <a href="logout.php?admin=1" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
  </div>

</body>
</html>
