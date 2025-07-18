<?php
session_start();
if (!isset($_SESSION['student'])) {
    header("Location: student_auth.php");
    exit();
}
$student = $_SESSION['student'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: url('image/BC4.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .dashboard {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(14px);
            padding: 35px;
            width: 380px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            text-align: center;
            color: #fff;
            animation: fadeIn 0.8s ease-in-out;
        }

        img {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            margin-bottom: 15px;
            object-fit: cover;
            border: 3px solid #fff;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            font-size: 15px;
            margin: 6px 0;
        }

        a.edit-btn, a.logout {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 8px;
            margin-top: 14px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        a.edit-btn {
            background: linear-gradient(135deg, #00bcd4, #2196f3);
            color: white;
        }

        a.edit-btn:hover {
            background: #0a74da;
        }

        a.logout {
            background: linear-gradient(135deg, #f44336, #e53935);
            color: white;
            margin-left: 10px;
        }

        a.logout:hover {
            background: #c62828;
        }

        .home-link {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .home-link a {
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 14px;
            border-radius: 10px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        .home-link a:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(-20px);}
            to {opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>

<div class="home-link">
    <a href="index.php">⬅ Back to Home</a>
</div>

<div class="dashboard">
    <?php if (!empty($student['profile_pic'])): ?>
        <img src="<?= $student['profile_pic'] ?>" alt="Profile Picture">
    <?php else: ?>
        <img src="uploads/profile_pics/default.png" alt="Default">
    <?php endif; ?>

    <h2><?= htmlspecialchars($student['fullname']); ?></h2>
    <p><strong>Email:</strong> <?= htmlspecialchars($student['email']); ?></p>
    <p><strong>Department:</strong> <?= htmlspecialchars($student['department']); ?></p>
    <p><strong>Level:</strong> <?= htmlspecialchars($student['level']); ?></p>
    <p><strong>Registered On:</strong> <?= htmlspecialchars($student['created_at']); ?></p>

    <a href="student_edit.php" class="edit-btn">✏ Edit Profile</a>
    <a href="student_auth.php?logout=true" class="logout">Logout</a>
</div>

</body>
</html>
