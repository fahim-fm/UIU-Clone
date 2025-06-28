<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: admin_login.php");
  exit();
}

include 'db_connect.php';

// Handle delete request
if (isset($_GET['delete_id'])) {
  $delete_id = $_GET['delete_id'];
  
  // Prepare DELETE query to remove the application
  $sql = "DELETE FROM applications WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $delete_id);

  // Execute the query
  if ($stmt->execute()) {
    echo "<script>alert('Application deleted successfully.'); window.location.href = 'view_applications.php';</script>";
  } else {
    echo "<script>alert('Error deleting application.');</script>";
  }
}

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
    .delete-btn {
      background-color: #dc3545;
      color: white;
      padding: 5px 10px;
      border: none;
      cursor: pointer;
    }
    .delete-btn:hover {
      background-color: #c82333;
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
    <th>Actions</th>
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
      <td>
        <!-- Delete Button -->
        <a href="view_applications.php?delete_id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this application?');">
          <button class="delete-btn">Delete</button>
        </a>
      </td>
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
