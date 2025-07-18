<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: admin_login.php");
  exit();
}

include 'db_connect.php';

// ✅ Delete event
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);

    // Fetch image to delete from folder
    $imgQuery = $conn->query("SELECT image FROM events WHERE id=$delete_id");
    if ($imgQuery && $imgQuery->num_rows > 0) {
        $imgRow = $imgQuery->fetch_assoc();
        if (!empty($imgRow['image']) && file_exists($imgRow['image'])) {
            unlink($imgRow['image']); // delete file
        }
    }

    $conn->query("DELETE FROM events WHERE id=$delete_id");
    header("Location: manage_events.php");
    exit();
}

// ✅ Fetch all events
$result = $conn->query("SELECT * FROM events ORDER BY date DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Events</title>
  <link rel="stylesheet" href="style.css">
  <style>
    table {
      width: 90%;
      margin: 20px auto;
      border-collapse: collapse;
    }
    table th, table td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: left;
    }
    table th {
      background: #333;
      color: #fff;
    }
    .btn {
      padding: 6px 12px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      color: white;
    }
    .edit-btn { background: #007bff; }
    .delete-btn { background: #dc3545; }
    .back-btn { background: #28a745; margin: 20px auto; display: block; width: 200px; text-align: center; }
  </style>
</head>
<body>

<h2 style="text-align:center;">Manage Events</h2>

<table>
  <tr>
    <th>ID</th>
    <th>Title</th>
    <th>Description</th>
    <th>Date</th>
    <th>Image</th>
    <th>Actions</th>
  </tr>

  <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['title']) ?></td>
      <td><?= htmlspecialchars(substr($row['description'],0,50)) ?>...</td>
      <td><?= $row['date'] ?></td>
      <td>
        <?php if (!empty($row['image'])): ?>
          <img src="<?= $row['image'] ?>" width="80">
        <?php else: ?>
          No Image
        <?php endif; ?>
      </td>
      <td>
        <a class="btn edit-btn" href="edit_event.php?id=<?= $row['id'] ?>">Edit</a>
        <a class="btn delete-btn" href="manage_events.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
      </td>
    </tr>
  <?php } ?>
</table>

<a href="admin_dashboard.php" class="btn back-btn">⬅ Back to Dashboard</a>

</body>
</html>
