<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: admin_login.php");
  exit();
}

include 'db_connect.php';
$sql = "SELECT * FROM applications ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Applications</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 30px;
      background: #f2f2f2;
    }
    h2 {
      text-align: center;
      color: #333;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: white;
    }
    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ccc;
    }
    th {
      background-color: #0066cc;
      color: white;
    }
    tr:hover {
      background-color: #f1f1f1;
    }
    .back-button {
      text-align: center;
      margin-top: 30px;
    }
    .back-button a {
      padding: 10px 20px;
      background-color: #0066cc;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }
    .back-button a:hover {
      background-color: #004999;
    }
  </style>
</head>
<body>

<h2>Submitted Applications</h2>

<?php if ($result->num_rows > 0): ?>
<table>
  <tr>
    <th>ID</th>
    <th>Full Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Program</th>
    <th>Message</th>
    <th>Submitted At</th>
  </tr>
  <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row["id"] ?></td>
      <td><?= htmlspecialchars($row["fullname"]) ?></td>
      <td><?= htmlspecialchars($row["email"]) ?></td>
      <td><?= htmlspecialchars($row["phone"]) ?></td>
      <td><?= htmlspecialchars($row["program"]) ?></td>
      <td><?= nl2br(htmlspecialchars($row["message"])) ?></td>
      <td><?= $row["submitted_at"] ?></td>
    </tr>
  <?php endwhile; ?>
</table>
<?php else: ?>
  <p>No applications found.</p>
<?php endif; ?>

<div class="back-button">
  <a href="admin_dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>

<?php $conn->close(); ?>
