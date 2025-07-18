<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['student'])) {
    header("Location: student_auth.php");
    exit();
}

$student = $_SESSION['student'];
$id = $student['id'];
$msg = "";

// ✅ Process profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $department = $conn->real_escape_string($_POST['department']);
    $level = $conn->real_escape_string($_POST['level']);
    
    // Profile picture upload
    $profile_pic = $student['profile_pic']; // keep old one if not uploaded
    if (!empty($_FILES['profile_pic']['name'])) {
        $uploadDir = "uploads/profile_pics/";
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = time() . "_" . basename($_FILES['profile_pic']['name']);
        $targetPath = $uploadDir . $fileName;

        $allowedTypes = ['jpg','jpeg','png','gif'];
        $ext = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
        if (in_array($ext, $allowedTypes)) {
            if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $targetPath)) {
                $profile_pic = $targetPath;
            } else {
                $msg = "⚠ Error uploading image!";
            }
        } else {
            $msg = "⚠ Only JPG, PNG, GIF allowed!";
        }
    }

    $conn->query("UPDATE students 
                  SET fullname='$fullname', department='$department', level='$level', profile_pic='$profile_pic' 
                  WHERE id=$id");

    // Update session data
    $_SESSION['student']['fullname'] = $fullname;
    $_SESSION['student']['department'] = $department;
    $_SESSION['student']['level'] = $level;
    $_SESSION['student']['profile_pic'] = $profile_pic;

    $msg = "✅ Profile updated!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
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
        }

        .form-box {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(14px);
            padding: 30px;
            width: 380px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            text-align: center;
            color: #fff;
            animation: fadeIn 0.8s ease-in-out;
        }

        .form-box h2 {
            margin-bottom: 15px;
            font-size: 26px;
            letter-spacing: 1px;
        }

        .msg {
            background: rgba(0,0,0,0.3);
            padding: 8px;
            border-radius: 8px;
            margin-bottom: 12px;
        }

        img {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            margin-bottom: 15px;
            object-fit: cover;
            border: 3px solid #fff;
        }

        label {
            display: block;
            text-align: left;
            margin: 6px 0;
            font-weight: 600;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: none;
            border-radius: 10px;
            background: rgba(255,255,255,0.2);
            color: #e10c50ff;
            font-size: 14px;
            outline: none;
        }

        input::placeholder {
            color: #ddd;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .back-link {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #fff;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #ffdede;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="form-box">
    <h2>✏ Edit Profile</h2>

    <?php if($msg) echo "<p class='msg'>$msg</p>"; ?>
    
    <!-- Show current profile pic -->
    <?php if(!empty($student['profile_pic'])): ?>
        <img src="<?= $student['profile_pic'] ?>" alt="Profile Picture">
    <?php else: ?>
        <img src="uploads/profile_pics/default.png" alt="Default">
    <?php endif; ?>
    
    <form method="post" enctype="multipart/form-data">
        <label>Full Name:</label>
        <input type="text" name="fullname" value="<?= htmlspecialchars($student['fullname']); ?>" required>
        
        <label>Department:</label>
        <select name="department" required>
            <option <?= $student['department']=="CSE"?"selected":"" ?>>CSE</option>
            <option <?= $student['department']=="EEE"?"selected":"" ?>>EEE</option>
            <option <?= $student['department']=="Business"?"selected":"" ?>>Business</option>
            <option <?= $student['department']=="Civil"?"selected":"" ?>>Civil</option>
        </select>

        <label>Level:</label>
        <select name="level" required>
            <option <?= $student['level']=="Undergraduate"?"selected":"" ?>>Undergraduate</option>
            <option <?= $student['level']=="Masters"?"selected":"" ?>>Masters</option>
        </select>

        <label>Profile Picture:</label>
        <input type="file" name="profile_pic" accept="image/*">

        <button type="submit">✅ Update Profile</button>
    </form>
    <a href="student_dashboard.php" class="back-link">⬅ Back to Dashboard</a>
</div>

</body>
</html>
