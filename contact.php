<?php
$messageSent = "";
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {


  // Get form data
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];

  // Insert into database
  $sql = "INSERT INTO contact_messages (fullname, email, subject, message)
          VALUES ('$fullname', '$email', '$subject', '$message')";
          
  if ($conn->query($sql) === TRUE) {
    $messageSent = "Message sent successfully.";
  } else {
    $messageSent = "Error: " . $conn->error;
  }

  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>UIU Clone</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="icon" type="image/png" href="image/United_International_University_Monogram.svg.png">

  <link rel="stylesheet" href="style.css" />
  
</head>
<body>

 <!-- Top bar -->
  <div class="top-bar">
    <div class="left-icons">🏠</div>
    <div class="top-links">
      <a href="fees.html">Tuition Fees & Waiver</a>
      <a href="apply_online.php">Apply Online</a>
      <a href="admin_login.php">Admin Login</a>
    </div>
    <div class="search">
      <input type="text" placeholder="Search...">
      <button>Search</button>
    </div>
  </div>

  <!-- Logo and main menu -->
  <header>
    <div class="logo">
      <img src="image/UIU-Logo_Final-1-1024x351.png" alt="UIU Logo">
    </div>
    <nav class="main-nav">
      <a href="index.php">Home</a>
      <a href="about.html">About</a>
      <a href="admission.html">Admission</a>
      <a href="academic.html">Academics</a>
      <a href="research.html">Research</a>
      <a href="#">Students</a>
      
      <a href="notices.php">Notices</a>
      <a href="contact.php">Contact</a>
    </nav>
  </header>

<div class="ccontact-section">
  <h1>Contact & Location</h1>
  <p class="address"><i class="fa fa-map-marker"></i> United City, Madani Avenue, Badda, Dhaka, Dhaka 1212, Bangladesh</p>

  <div class="contact-box">
    <p><i class="fa fa-phone"></i> 09604 848848</p>
    <p><i class="fa fa-mobile"></i> <strong>Admission Office:</strong> +8801759039498, +8801759039465,<br>
    +8801759039451, +8801914001470, +8801550704732</p>
  </div>
</div>

<div class="fform-section">
<p class="center-text">Please use the following form to contact the department/person.</p>

  <div class="fform-box">
    <h2>Fill up the form</h2>
    <form method="post">
      <input type="text" name="fullname" placeholder="Enter your Full Name" required>
      <input type="email" name="email" placeholder="Enter your email" required>
      <input type="text" name="subject" placeholder="Mention your subject" required>
      <textarea name="message" placeholder="Brief description of your question*" required></textarea>
      <button type="submit">Send Message</button>
    </form>
    <?php if (!empty($messageSent)): ?>
    <div class="message"><?= $messageSent ?></div>
  <?php endif; ?>
  </div>
</div>
<!-- Footer Section -->
<footer class="uiu-footer">
   
    <div class="footer-content">
      <div class="footer-column">
        <img src="image/header-logo.png" alt="UIU Logo" class="footer-logo">
        <div class="social-icons">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-youtube"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
  
      <div class="footer-column">
        <h4>About UIU</h4>
        <ul>
          <li><a href="#">Why UIU</a></li>
          <li><a href="#">Vision Mission Goals</a></li>
          <li><a href="#">General Information</a></li>
          <li><a href="#">UIU Campus</a></li>
          <li><a href="#">Guiding Principles</a></li>
          <li><a href="#">Ranking & Accreditation</a></li>
          <li><a href="#">Convocation</a></li>
          <li><a href="#">UIU In Media</a></li>
          <li><a href="#">Gallery</a></li>
          <li><a href="#">Career</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </div>
  
      <div class="footer-column">
        <h4>Departments</h4>
        <ul>
          <li><a href="#">Dept. of CSE</a></li>
          <li><a href="#">B.Sc. in Data Science</a></li>
          <li><a href="#">Dept. of EEE</a></li>
          <li><a href="#">Dept. of Civil Engineering</a></li>
          <li><a href="#">Dept. of Pharmacy</a></li>
          <li><a href="#">Dept. of English</a></li>
          <li><a href="#">Dept. of EDS</a></li>
          <li><a href="#">Dept. of MSJ</a></li>
          <li><a href="#">SoBE (BBA, AIS, MBA, EMBA)</a></li>
          <li><a href="#">Dept. of Economics</a></li>
          <li><a href="#">Dept. of BGE</a></li>
        </ul>
      </div>
  
      <div class="footer-column">
        <h4>Admission</h4>
        <ul>
          <li><a href="#">Admission</a></li>
          <li><a href="#">Tuition Fees & Waiver</a></li>
          <li><a href="#">Admission Requirements</a></li>
          <li><a href="#">Admission Test Result</a></li>
          <li><a href="#">Admission Procedure</a></li>
          <li><a href="#">Admission Dates</a></li>
          <li><a href="#">Apply Online</a></li>
          <li><a href="#">International Admission</a></li>
          <li><a href="#">Global Opportunities</a></li>
          <li><a href="#">International Collaboration</a></li>
          <li><a href="#">FAQ</a></li>
        </ul>
      </div>
  
      <div class="footer-column">
        <h4>Important Links</h4>
        <ul>
          <li><a href="#">UIU Sustainability</a></li>
          <li><a href="#">Shuttle Schedule</a></li>
          <li><a href="#">Transport Services</a></li>
          <li><a href="#">Payment Procedure</a></li>
          <li><a href="#">Student e-Resources</a></li>
          <li><a href="#">Important Contact</a></li>
        </ul>
      </div>
  
      <div class="footer-column">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="#">UCAM</a></li>
          <li><a href="#">eLMS</a></li>
          <li><a href="#">Parent Portal</a></li>
          <li><a href="#">Classroom Booking</a></li>
          <li><a href="#">Degree Verification</a></li>
          <li><a href="#">Necessary Forms</a></li>
          <li><a href="#">Notice</a></li>
          <li><a href="#">News</a></li>
          <li><a href="#">Event</a></li>
        </ul>
      </div>
    </div>
    <!-- Footer Bottom Info -->
  <div class="footer-bottom">
    <p>United City, Madani Ave, Dhaka 1212</p>
    <div class="footer-links">
      <a href="#">Privacy Policy</a>
      <a href="#">Accessibility Assistance</a>
      <a href="#">Copyright</a>
      <a href="#">Site Information</a>
    </div>
  </div>
  
  </footer>
  </body>
  </html>
  