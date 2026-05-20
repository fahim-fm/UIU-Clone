<?php
include 'db_connect.php';
$messageSent = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $conn->real_escape_string(trim($_POST['fullname'] ?? ''));
    $email    = $conn->real_escape_string(trim($_POST['email']    ?? ''));
    $subject  = $conn->real_escape_string(trim($_POST['subject']  ?? ''));
    $message  = $conn->real_escape_string(trim($_POST['message']  ?? ''));

    if ($fullname && $email && $subject && $message) {
        $sql = "INSERT INTO contact_messages (fullname, email, subject, message)
                VALUES ('$fullname', '$email', '$subject', '$message')";
        $messageSent = $conn->query($sql)
            ? 'Message sent successfully.'
            : 'Error: ' . htmlspecialchars($conn->error);
    } else {
        $messageSent = 'Please fill in all fields.';
    }
}

$pageTitle = 'Contact – UIU';
include 'includes/header.php';
?>

  <div class="ccontact-section">
    <h1>Contact &amp; Location</h1>
    <p class="address"><i class="fa fa-map-marker"></i> United City, Madani Avenue, Badda, Dhaka 1212, Bangladesh</p>
    <div class="ccontact-box">
      <p><i class="fa fa-phone"></i> 09604 848848</p>
      <p><i class="fa fa-mobile"></i> <strong>Admission Office:</strong><br>
         +8801759039498, +8801759039465, +8801759039451,<br>
         +8801914001470, +8801550704732</p>
    </div>
  </div>

  <div class="fform-section">
    <p class="center-text">Please use the following form to contact the department/person.</p>
    <div class="fform-box">
      <h2>Fill up the form</h2>
      <form method="post" action="">
        <input type="text"  name="fullname" placeholder="Enter your Full Name" required>
        <input type="email" name="email"    placeholder="Enter your email"     required>
        <input type="text"  name="subject"  placeholder="Mention your subject" required>
        <textarea name="message" placeholder="Brief description of your question*" rows="5" required></textarea>
        <button type="submit">Send Message</button>
      </form>
      <?php if (!empty($messageSent)): ?>
        <div class="message"><?= htmlspecialchars($messageSent) ?></div>
      <?php endif; ?>
    </div>
  </div>

<?php include 'includes/footer.php'; ?>
