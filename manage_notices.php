<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header('Location: admin_login.php'); exit(); }
include 'db_connect.php';

if (isset($_GET['delete'])) {
    $id  = (int)$_GET['delete'];
    $res = $conn->query("SELECT pdf_file FROM notices WHERE id=$id");
    if ($res && $row = $res->fetch_assoc()) {
        if (!empty($row['pdf_file']) && file_exists($row['pdf_file'])) unlink($row['pdf_file']);
    }
    $conn->query("DELETE FROM notices WHERE id=$id");
    header('Location: manage_notices.php');
    exit();
}

$result = $conn->query("SELECT * FROM notices ORDER BY date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Notices – UIU Admin</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
  <link rel="stylesheet" href="admin-table.css">
</head>
<body>
<div class="admin-wrap">
  <h2>📋 Manage Notices</h2>
  <div class="back-row" style="margin-bottom:16px;">
    <a href="add_notice.php"       class="btn btn-edit">+ Add New Notice</a>
    <a href="admin_dashboard.php"  class="btn btn-back" style="margin-left:8px;">⬅ Dashboard</a>
  </div>
  <div class="table-responsive">
    <table>
      <thead>
        <tr><th>#</th><th>Title</th><th>Date</th><th>PDF</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= (int)$row['id'] ?></td>
              <td><?= htmlspecialchars($row['title']) ?></td>
              <td><?= htmlspecialchars($row['date']) ?></td>
              <td>
                <?php if (!empty($row['pdf_file'])): ?>
                  <a href="<?= htmlspecialchars($row['pdf_file']) ?>" target="_blank" rel="noopener">📄 View</a>
                <?php else: ?>—<?php endif; ?>
              </td>
              <td class="actions">
                <a class="btn btn-edit"   href="edit_notice.php?id=<?= (int)$row['id'] ?>">Edit</a>
                <a class="btn btn-delete" href="manage_notices.php?delete=<?= (int)$row['id'] ?>"
                   onclick="return confirm('Delete this notice?')">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="5" style="text-align:center">No notices found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
