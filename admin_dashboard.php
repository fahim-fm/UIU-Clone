<?php
session_start();
if (!isset($_SESSION["admin_logged_in"])) {
  header("Location: admin_login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Inter', sans-serif;
  }

  body {
    background: url('image/BC4.jpg') no-repeat center center fixed;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
  }

  .dashboard-container {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(15px);
    padding: 50px 40px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    text-align: center;
    width: 480px;
    animation: fadeIn 1s ease-in-out;
  }

  .dashboard-container h2 {
    color: #fff;
    font-size: 28px;
    margin-bottom: 35px;
    letter-spacing: 1px;
  }

  nav {
    display: flex;
    flex-direction: column;
    gap: 18px;
  }

  nav a {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-decoration: none;
    padding: 14px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 16px;
    color: #fff;
    background: linear-gradient(135deg, #ff6a00, #ee0979);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  nav a:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
  }

  .logout-btn {
    display: inline-block;
    margin-top: 25px;
    color: #fff;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
  }
  .logout-btn:hover {
    color: #ffd6d6;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
  }
  </style>
</head>
<body>

  <div class="dashboard-container">
    <h2>⚡ Admin Dashboard</h2>
    <nav>
      <a href="add_notice.php"><i class="fa-solid fa-plus"></i> Add Notice</a>
      <a href="upload_event.php"><i class="fa-solid fa-calendar-plus"></i> Add Event</a>
      <a href="view_messages.php"><i class="fa-solid fa-envelope-open-text"></i> View Messages</a>
      <a href="view_applications.php"><i class="fa-solid fa-file-lines"></i> View Applications</a>
      <a href="manage_events.php"><i class="fa-solid fa-calendar-days"></i> Manage Events</a>
      <a href="manage_notices.php"><i class="fa-solid fa-bullhorn"></i> Manage Notices</a>
    </nav>
    <a href="logout.php" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
  </div>

</body>
</html>
