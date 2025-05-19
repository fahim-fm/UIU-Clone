<?php
// Step 2.1: Connect to the database
$conn = new mysqli("localhost", "root", "", "notice"); // change "uiu_database" as per your DB
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2.2: Get all notices
$sql = "SELECT * FROM notices ORDER BY date DESC";
$result = $conn->query($sql);
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

  <!-- Hero slideshow -->
  <div class="slideshow">
    <input type="radio" name="slider" id="slide1" checked>
    <input type="radio" name="slider" id="slide2">
    <input type="radio" name="slider" id="slide3">

    <div class="slides">
      <div class="slide"><img src="image/BC4.jpg" alt="Slide 1"></div>
      <div class="slide"><img src="image/gradute.webp" alt="Slide 2"></div>
      <div class="slide"><img src="image/sprin2025.jpg" alt="Slide 3"></div>
    </div>

    <div class="hero-content">
      <p>Admission Open Summer 2025 Trimester</p>
      <h1>United International University</h1>
      <a href="apply_online.php"><button>Apply Now</button></a>

    </div>

    <div class="arrow left-arrow">
      <label for="slide3" class="to-s1">❮</label>
      <label for="slide1" class="to-s2">❮</label>
      <label for="slide2" class="to-s3">❮</label>
    </div>
    
    <div class="arrow right-arrow">
      <label for="slide2" class="to-s1">❯</label>
      <label for="slide3" class="to-s2">❯</label>
      <label for="slide1" class="to-s3">❯</label>
    </div>
  </div>

  <!-- About Section -->
  <section class="about-section">
    <div class="about-content">
      <h2>Quest For Excellence</h2>
      <p>The mission of UIU is to create excellent human resources with intellectual, creative, technical, moral and practical skills to serve community, industry and region. We do it by developing integrated, interactive, involved and caring relationships among teachers, students, guardians and employers.</p>
      <a href="coming_soon.html"><button>More About UIU</button></a>
    </div>
  </section>

  <!-- Admission Section -->
  <section class="admission-section">
    <h2>Admission</h2>
    <p>
      UIU offers a comprehensive admission process, welcoming students into diverse programs that foster academic growth and real-world skills.
    </p>
    <div class="admission-cards">
      <div class="card">
        <img src="image/sprin2025.jpg" alt="Undergraduate Programs">
        <h4>Undergraduate Programs</h4>
        <p>UIU offers 12 undergraduate programs from 3 different schools.</p>
        <a href="ungad.html"><button>Undergraduate Programs</button></a>
      </div>
      <div class="card">
        <img src="image/gradute.webp" alt="Graduate Programs">
        <h4>Graduate Programs</h4>
        <p>UIU offers 6 graduate programs from 3 different schools.</p>
       <a href="ungad.html"><button>Graduate Programs</button></a>
      </div>
      <div class="card">
        <img src="image/download2.jpeg" alt="Continuing Education">
        <h4>Continuing Education</h4>
        <p>From different centers and institutes UIU offers over 40 short professional courses.</p>
        <button>Continuing Education</button>
      </div>
    </div>
    <div class="more-admission">
      <button>More About Admission</button>
    </div>
  </section>

  <!-- Recognition Section -->
  <section class="recognition-section">
    <h2>Recognition</h2>
    <p>
      United International University is recognized nationally and globally for excellence in teaching and research, reflected through its prestigious rankings.
    </p>
  </section>
  <section class="notices">
    <div class="container">
      <h2>Notices</h2>
      <p class="notice-description">
        Stay Updated: Explore the Latest Notices from UIU for Key Information on Academic Schedules,
        Upcoming Events, and Essential University Announcements. Keep Informed, Stay Ahead!
      </p>
  
      <div class="notice-grid">
      <?php if ($result->num_rows > 0): ?>
       <?php while($row = $result->fetch_assoc()): ?>
  <div class="notice-item">
    <span>📅 <?= date("F d, Y", strtotime($row['date'])) ?></span>
    <p><?= htmlspecialchars($row['title']) ?></p>
    <?php if (!empty($row['pdf_file'])): ?>
      <a href="<?= htmlspecialchars($row['pdf_file']) ?>" target="_blank">📄 View PDF</a>
    <?php endif; ?>
  </div>
<?php endwhile; ?>

      <?php else: ?>
        <p>No notices found.</p>
      <?php endif; ?>
    </div>
  </div>
  </section>
  <!-- Events Section -->
<section class="events-section">
  <h2>Events</h2>
  <p>Explore UIU's Vibrant Campus Life: Check Out Upcoming Events, Workshops, <br>
    and Gatherings. Connect, Learn, and Grow with Our Engaging University Events and Activities!
  </p>

  <div class="event-grid">
      <?php
        $result = $conn->query("SELECT * FROM events ORDER BY date DESC");
        while ($row = $result->fetch_assoc()) {
          echo "<div class='event-item'>";
          echo "<h3>" . $row['title'] . "</h3>";
          echo "<span>📅 " . $row['date'] . "</span>";
          echo "<p>" . $row['description'] . "</p>";
          if ($row['image']) {
            echo "<img src='" . $row['image'] . "' width='400'>";
          }
          echo "</div>";
        }
      ?>
    </div>
  </div>
</section>


<!-- Footer Section -->
<footer class="uiu-footer">
  <div class="footer-bg"></div>
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
