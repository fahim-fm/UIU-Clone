<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header('Location: admin_login.php'); exit(); }
include 'db_connect.php';

$result = $conn->query("SELECT * FROM students ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Students – UIU Admin</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
  <link rel="stylesheet" href="admin-table.css">
</head>
<body>
<div class="admin-wrap">
  <h2>👥 Manage Students</h2>
  <div class="back-row" style="margin-bottom:16px;">
    <a href="admin_dashboard.php" class="btn btn-back">⬅ Dashboard</a>
  </div>
  <div class="table-responsive">
    <table>
      <thead>
        <tr><th>Photo</th><th>Full Name</th><th>Email</th><th>Dept.</th><th>Level</th><th>Registered</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td>
                <img class="thumb"
                  src="<?= !empty($row['profile_pic']) ? htmlspecialchars($row['profile_pic']) : 'uploads/profile_pics/default.png' ?>"
                  alt="photo">
              </td>
              <td><?= htmlspecialchars($row['fullname']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['department']) ?></td>
              <td><?= htmlspecialchars($row['level']) ?></td>
              <td><?= htmlspecialchars($row['created_at']) ?></td>
              <td class="actions">
                <a class="btn btn-edit"   href="edit_student.php?id=<?= (int)$row['id'] ?>">Edit</a>
                <a class="btn btn-delete" href="delete_student.php?id=<?= (int)$row['id'] ?>"
                   onclick="return confirm('Delete this student?')">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="7" style="text-align:center">No students found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
