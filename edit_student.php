<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
include 'db_connect.php';

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM students WHERE id=$id");
if ($result->num_rows == 0) {
    die("Student not found!");
}
$student = $result->fetch_assoc();

$msg = "";

// ✅ Update student details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $department = $conn->real_escape_string($_POST['department']);
    $level = $conn->real_escape_string($_POST['level']);

    $conn->query("UPDATE students SET fullname='$fullname', department='$department', level='$level' WHERE id=$id");
    $msg = "✅ Student updated successfully!";
    // Refresh data
    $student = $conn->query("SELECT * FROM students WHERE id=$id")->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Edit Student</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f0f4ff;
            margin: 0;
            padding: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-box {
            background: #fff;
            padding: 30px 35px;
            width: 420px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 50, 0.1);
            text-align: center;
            color: #333;
            animation: fadeIn 0.8s ease forwards;
        }

        h2 {
            margin-bottom: 25px;
            font-weight: 600;
            color: #0052cc;
            letter-spacing: 0.5px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            text-align: left;
            color: #444;
        }

        input[type="text"], select {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 20px;
            border: 1.8px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus, select:focus {
            border-color: #2575fc;
            outline: none;
            box-shadow: 0 0 8px rgba(37, 117, 252, 0.4);
        }

        button {
            width: 100%;
            background: #2575fc;
            color: white;
            font-size: 16px;
            font-weight: 600;
            padding: 14px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background: #0052cc;
            transform: translateY(-2px);
        }

        .msg {
            margin-bottom: 18px;
            font-weight: 600;
            color: green;
            background: #e0f1ff;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 1px 4px rgba(0, 82, 204, 0.2);
        }

        a.back-link {
            display: inline-block;
            margin-top: 22px;
            text-decoration: none;
            font-weight: 600;
            color: #2575fc;
            transition: color 0.3s ease;
        }

        a.back-link:hover {
            color: #0052cc;
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <div class="form-box">
        <h2>Edit Student</h2>
        <?php if ($msg) echo "<div class='msg'>$msg</div>"; ?>
        <form method="post">
            <label for="fullname">Full Name</label>
            <input id="fullname" type="text" name="fullname" value="<?= htmlspecialchars($student['fullname']); ?>" required>

            <label for="department">Department</label>
            <select id="department" name="department" required>
                <option value="CSE" <?= $student['department'] === "CSE" ? "selected" : "" ?>>CSE</option>
                <option value="EEE" <?= $student['department'] === "EEE" ? "selected" : "" ?>>EEE</option>
                <option value="Business" <?= $student['department'] === "Business" ? "selected" : "" ?>>Business</option>
                <option value="Civil" <?= $student['department'] === "Civil" ? "selected" : "" ?>>Civil</option>
            </select>

            <label for="level">Level</label>
            <select id="level" name="level" required>
                <option value="Undergraduate" <?= $student['level'] === "Undergraduate" ? "selected" : "" ?>>Undergraduate</option>
                <option value="Masters" <?= $student['level'] === "Masters" ? "selected" : "" ?>>Masters</option>
            </select>

            <button type="submit">Update</button>
        </form>
        <a href="manage_students.php" class="back-link">⬅ Back to Manage Students</a>
    </div>

</body>
</html>
