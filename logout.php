<?php
session_start();
$redirect = isset($_GET['admin']) ? 'admin_login.php' : 'student_auth.php';
session_destroy();
header('Location: ' . $redirect);
exit();
