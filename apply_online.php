<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Apply Online - UIU</title>
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

    .back-home {
      position: absolute;
      top: 20px;
      left: 20px;
    }

    .back-home a {
      text-decoration: none;
      background: rgba(0,0,0,0.4);
      color: white;
      padding: 10px 20px;
      border-radius: 8px;
      transition: background 0.3s ease;
    }

    .back-home a:hover {
      background: rgba(0,0,0,0.6);
    }

    .container {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(12px);
      max-width: 600px;
      width: 90%;
      padding: 40px;
      border-radius: 18px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.2);
      animation: fadeIn 0.8s ease-in-out;
      color: #fff;
    }

    h2 {
      text-align: center;
      color: #fff;
      font-size: 28px;
      margin-bottom: 25px;
    }

    form input, form textarea, form select {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: none;
      border-radius: 10px;
      background:linear-gradient(190deg, #6a11cb, #2575fc);
      color: #fff;
      font-size: 15px;
      outline: none;
    }

    form input::placeholder, form textarea::placeholder {
      color: #ddd;
    }

    form select option {
      color: #000;
    }

    button {
      background: linear-gradient(135deg, #f804ecff, #25fc90ff);
      color: white;
      padding: 12px 20px;
      border: none;
      width: 100%;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    button:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .success {
      text-align: center;
      color: #b8ffb8;
      background: rgba(0, 128, 0, 0.2);
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 8px;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

<div class="back-home">
  <a href="index.php">⬅ Back to Home</a>
</div>

<div class="container">
  <h2>📝 Apply Online</h2>

  <?php if (isset($_GET['success'])): ?>
    <div class="success">✅ Application submitted successfully!</div>
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
</div>

</body>
</html>
