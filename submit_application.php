<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $conn->real_escape_string(trim($_POST['fullname'] ?? ''));
    $email    = $conn->real_escape_string(trim($_POST['email']    ?? ''));
    $phone    = $conn->real_escape_string(trim($_POST['phone']    ?? ''));
    $program  = $conn->real_escape_string($_POST['program']       ?? '');
    $message  = $conn->real_escape_string(trim($_POST['message']  ?? ''));

    if ($fullname && $email && $phone && $program) {
        $sql = "INSERT INTO applications (fullname, email, phone, program, message)
                VALUES ('$fullname','$email','$phone','$program','$message')";
        if ($conn->query($sql)) {
            header('Location: apply_online.php?success=1');
            exit();
        } else {
            die('Database error: ' . htmlspecialchars($conn->error));
        }
    } else {
        header('Location: apply_online.php?error=missing');
        exit();
    }
} else {
    header('Location: apply_online.php');
    exit();
}
