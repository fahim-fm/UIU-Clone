<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: admin_login.php");
  exit();
}

include 'db_connect.php';

// ✅ Delete notice
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);

    // Fetch PDF file to delete from folder
    $pdfQuery = $conn->query("SELECT pdf_file FROM notices WHERE id=$delete_id");
    if ($pdfQuery && $pdfQuery->num_rows > 0) {
        $pdfRow = $pdfQuery->fetch_assoc();
        if (!empty($pdfRow['pdf_file']) && file_exists($pdfRow['pdf_file'])) {
            unlink($pdfRow['pdf_file']); // delete file
        }
    }

    $conn->query("DELETE FROM notices WHERE id=$delete_id");
    header("Location: manage_notices.php");
    exit();
}

// ✅ Fetch all notices
$result = $conn->query("SELECT * FROM notices ORDER BY date DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Notices</title>
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

<h2 style="text-align:center;">Manage Notices</h2>

<table>
  <tr>
    <th>ID</th>
    <th>Title</th>
    <th>Date</th>
    <th>PDF</th>
    <th>Actions</th>
  </tr>

  <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['title']) ?></td>
      <td><?= $row['date'] ?></td>
      <td>
        <?php if (!empty($row['pdf_file'])): ?>
          <a href="<?= $row['pdf_file'] ?>" target="_blank">📄 View PDF</a>
        <?php else: ?>
          No PDF
        <?php endif; ?>
      </td>
      <td>
        <a class="btn edit-btn" href="edit_notice.php?id=<?= $row['id'] ?>">Edit</a>
        <a class="btn delete-btn" href="manage_notices.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
      </td>
    </tr>
  <?php } ?>
</table>

<a href="admin_dashboard.php" class="btn back-btn">⬅ Back to Dashboard</a>

</body>
</html>
