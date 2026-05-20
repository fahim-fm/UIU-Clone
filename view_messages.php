<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header('Location: admin_login.php'); exit(); }
include 'db_connect.php';

if (isset($_GET['delete_id'])) {
    $del_id = (int)$_GET['delete_id'];
    $stmt   = $conn->prepare("DELETE FROM contact_messages WHERE id=?");
    $stmt->bind_param('i', $del_id);
    $stmt->execute();
    $stmt->close();
    header('Location: view_messages.php');
    exit();
}

$result = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Messages – UIU Admin</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
  <link rel="stylesheet" href="admin-table.css">
</head>
<body>
<div class="admin-wrap">
  <h2>✉️ Contact Messages</h2>
  <div class="back-row" style="margin-bottom:16px;">
    <a href="admin_dashboard.php" class="btn btn-back">⬅ Dashboard</a>
  </div>
  <div class="table-responsive">
    <table>
      <thead>
        <tr><th>#</th><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Date</th><th>Action</th></tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= (int)$row['id'] ?></td>
              <td><?= htmlspecialchars($row['fullname']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['subject']) ?></td>
              <td><?= nl2br(htmlspecialchars(mb_substr($row['message'], 0, 100))) ?>…</td>
              <td><?= htmlspecialchars($row['created_at']) ?></td>
              <td>
                <a class="btn btn-delete" href="view_messages.php?delete_id=<?= (int)$row['id'] ?>"
                   onclick="return confirm('Delete this message?')">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="7" style="text-align:center">No messages found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
