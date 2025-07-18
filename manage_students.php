<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
include 'db_connect.php';

$result = $conn->query("SELECT * FROM students");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Students</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; padding: 20px; }
        table {
            width: 90%; margin: auto; border-collapse: collapse; background: #fff;
        }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: center; }
        th { background: #333; color: #fff; }
        img { width: 50px; height: 50px; border-radius: 50%; }
        a.btn { padding: 5px 10px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .delete { background: red; }
            .back-btn { background: #28a745; margin: 20px auto; display: block; width: 200px; text-align: center; }

    </style>
</head>
<body>
    <h2 style="text-align:center;">Manage Students</h2>
    <table>
        <tr>
            <th>Photo</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Department</th>
            <th>Level</th>
            <th>Registered</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td>
                <?php if(!empty($row['profile_pic'])): ?>
                    <img src="<?= $row['profile_pic'] ?>" alt="Profile">
                <?php else: ?>
                    <img src="uploads/profile_pics/default.png" alt="Default">
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($row['fullname']); ?></td>
            <td><?= htmlspecialchars($row['email']); ?></td>
            <td><?= htmlspecialchars($row['department']); ?></td>
            <td><?= htmlspecialchars($row['level']); ?></td>
            <td><?= htmlspecialchars($row['created_at']); ?></td>
            <td>
                <a class="btn" href="edit_student.php?id=<?= $row['id'] ?>">Edit</a>
                <a class="btn delete" href="delete_student.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this student?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    
</body>
<a href="admin_dashboard.php" class="btn back-btn">⬅ Back to Dashboard</a>
</html>
