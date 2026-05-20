<?php
$pageTitle = 'Apply Online – UIU';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
  <link rel="stylesheet" href="style.css">
</head>
<body class="glass-page">

  <div class="back-home"><a href="index.php">&#8592; Back to Home</a></div>

  <div class="apply-container">
    <h2>&#128221; Apply Online</h2>

    <?php if (isset($_GET['success'])): ?>
      <div class="success">&#10003; Application submitted successfully!</div>
    <?php endif; ?>

    <form action="submit_application.php" method="POST">
      <input type="text"  name="fullname" placeholder="Full Name"         required>
      <input type="email" name="email"    placeholder="Email Address"     required>
      <input type="text"  name="phone"    placeholder="Phone Number"      required>
      <select name="program" required>
        <option value="">-- Select Program --</option>
        <option value="BSc in CSE">BSc in CSE</option>
        <option value="BBA">BBA</option>
        <option value="BSc in EEE">BSc in EEE</option>
        <option value="BA in English">BA in English</option>
      </select>
      <textarea name="message" placeholder="Write your message..." rows="5"></textarea>
      <button type="submit">Submit Application</button>
    </form>
  </div>

</body>
</html>
