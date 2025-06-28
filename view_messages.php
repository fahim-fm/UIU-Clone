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

  // Prepare a SQL DELETE query to delete the message with the given ID
  $sql = "DELETE FROM contact_messages WHERE id = ?";
  
  // Prepare the statement
  $stmt = $conn->prepare($sql);

  // Bind the ID parameter to the query (i for integer)
  $stmt->bind_param("i", $delete_id);

  // Execute the query and check if the record was deleted
  if ($stmt->execute()) {
    // If the delete is successful, show an alert and reload the page
    echo "<script>alert('Message deleted successfully.'); window.location.href = 'view_messages.php';</script>";
  } else {
    // If there’s an error, show an error message
    echo "<script>alert('Error deleting message.');</script>";
  }
}

// Fetch messages to display
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
    .delete-btn {
      background-color: #dc3545;
      color: white;
      border: none;
      padding: 5px 10px;
      cursor: pointer;
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
    <th>Actions</th>
  </tr>
  <?php while($row = $result->fetch_assoc()): ?>
  <tr>
    <td><?= $row['id'] ?></td>
    <td><?= htmlspecialchars($row['fullname']) ?></td>
    <td><?= htmlspecialchars($row['email']) ?></td>
    <td><?= htmlspecialchars($row['subject']) ?></td>
    <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
    <td><?= $row['created_at'] ?></td>
    <td>
      <a href="view_messages.php?delete_id=<?= $row['id'] ?>">
        <button class="delete-btn" onclick="return confirm('Are you sure you want to delete this message?');">Delete</button>
      </a>
    </td>
  </tr>
  <?php endwhile; ?>
</table>

<a href="admin_dashboard.php">
  <button style="margin-top: 15px; background-color: #28a745;">Back to Dashboard</button>
</a>

</body>
</html>

<?php $conn->close(); ?>
