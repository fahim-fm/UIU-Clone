<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Apply Online - UIU</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 40px;
    }

    .container {
      max-width: 600px;
      background: #fff;
      margin: auto;
      padding: 30px;
      box-shadow: 0 0 10px #ccc;
      border-radius: 10px;
    }

    h2 {
      text-align: center;
      color: #0066cc;
    }

    form input, form textarea, form select {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    button {
      background-color: #0066cc;
      color: white;
      padding: 12px 20px;
      border: none;
      width: 100%;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background-color: #004999;
    }

    .success {
      text-align: center;
      color: green;
      margin-bottom: 10px;
    }

    .dashboard-link {
      text-align: center;
      margin-top: 20px;
    }

    .dashboard-link a {
      text-decoration: none;
      background-color: #444;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
    }

    .dashboard-link a:hover {
      background-color: #222;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Apply Online</h2>

  <?php if (isset($_GET['success'])): ?>
    <div class="success">Application submitted successfully!</div>
  <?php endif; ?>

  <form action="submit_application.php" method="POST">
    <input type="text" name="fullname" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email Address" required>
    <input type="text" name="phone" placeholder="Phone Number" required>
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

  <div class="dashboard-link">
    <a href="index.php">Back to Home</a>
  </div>
</div>

</body>
</html>
