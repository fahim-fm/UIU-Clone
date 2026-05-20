<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Delete profile pic file if exists
    $res = $conn->query("SELECT profile_pic FROM students WHERE id=$id");
    if ($res && $row = $res->fetch_assoc()) {
        if (!empty($row['profile_pic']) && file_exists($row['profile_pic'])) {
            unlink($row['profile_pic']);
        }
    }
    $conn->query("DELETE FROM students WHERE id=$id");
}
header('Location: manage_students.php');
exit();
