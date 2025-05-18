<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: admin_login.php");
  exit();
}

// DB connection
$conn = new mysqli("localhost", "root", "", "notice");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch messages
$sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>View Contact Messages</title>
  <style>
    body {
      font-family: Arial;
      margin: 20px;
    }
    h2 {
      color: #333;
    }
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 12px;
      text-align: left;
    }
    th {
      background-color: #2c3e50;
      color: white;
    }
    tr:nth-child(even) {
      background-color: #f4f4f4;
    }
  </style>
</head>
<body>

<h2>Received Contact Messages</h2>

<table>
  <tr>
    <th>ID</th>
    <th>Full Name</th>
    <th>Email</th>
    <th>Subject</th>
    <th>Message</th>
    <th>Date</th>
  </tr>
  <?php while($row = $result->fetch_assoc()): ?>
  <tr>
    <td><?= $row['id'] ?></td>
    <td><?= htmlspecialchars($row['fullname']) ?></td>
    <td><?= htmlspecialchars($row['email']) ?></td>
    <td><?= htmlspecialchars($row['subject']) ?></td>
    <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
    <td><?= $row['created_at'] ?></td>
  </tr>
  <?php endwhile; ?>
</table>
<a href="admin_dashboard.php">
  <button style="margin-top: 15px; background-color: #28a745;">Back to Dashboard</button>
</a>
</body>
</html>

<?php $conn->close(); ?>
