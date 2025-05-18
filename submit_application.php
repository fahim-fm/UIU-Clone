<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fullname = $_POST["fullname"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $program = $_POST["program"];
  $message = $_POST["message"];

  $sql = "INSERT INTO applications (fullname, email, phone, program, message)
          VALUES ('$fullname', '$email', '$phone', '$program', '$message')";

  if ($conn->query($sql) === TRUE) {
    header("Location: apply_online.php?success=1");
    exit();
  } else {
    echo "Error: " . $conn->error;
  }

  $conn->close();
}
?>
