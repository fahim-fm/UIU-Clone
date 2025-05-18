<?php
session_start();
if (!isset($_SESSION["admin_logged_in"])) {
  header("Location: login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
  <style>
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: 'Inter', sans-serif;
  }

  body {
    background: url('image/BC4.jpg') no-repeat center center fixed;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }

  .dashboard-container {
    background: rgba(255, 255, 255, 0.95);
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    max-width: 400px;
    width: 100%;
    text-align: center;
  }

  h2 {
    margin-bottom: 25px;
    color: #333;
    font-size: 24px;
  }

  nav {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-bottom: 25px;
  }

  nav a {
    text-decoration: none;
    background-color: #007BFF;
    color: #fff;
    padding: 12px 20px;
    border-radius: 8px;
    font-weight: 600;
    transition: background-color 0.3s ease;
  }

  nav a:hover {
    background-color: #0056b3;
  }

  .logout-btn {
    display: inline-block;
    margin-top: 10px;
    text-decoration: none;
    color: #e63946;
    font-weight: 600;
    transition: color 0.3s ease;
  }

  .logout-btn:hover {
    color: #c1121f;
  }
</style>

</head>
<body>

  <div class="dashboard-container">
    <h2>Welcome to Admin Panel</h2>
    <nav>
      <a href="add_notice.php">➕ Add Notice</a>
      <a href="upload_event.php">🎉 Add Event</a>
      <a href="view_messages.php">📥 View Messages</a>
      <a href="view_applications.php">📑 View Applications</a>
    </nav>
    <a href="logout.php" class="logout-btn">🚪 Logout</a>
  </div>

</body>
</html>
