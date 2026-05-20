<?php
// Shared header/nav — include at top of every page
// $pageTitle should be set before including this file
if (!isset($pageTitle))
  $pageTitle = 'UIU Clone';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="icon" type="image/png" href="image/United_International_University_Monogram.svg.png">
  <link rel="stylesheet" href="style.css" />
</head>

<body>

  <!-- Top bar -->
  <div class="top-bar">
    <div class="left-icons"><a href="index.php" aria-label="Home">🏠</a></div>
    <div class="top-links">
      <a href="fees.php">Tuition Fees &amp; Waiver</a>
      <a href="apply_online.php">Apply Online</a>
      <a href="admin_login.php">Admin Login</a>
      <a href="student_auth.php">Student Login</a>
    </div>
    <div class="search">
      <input type="text" placeholder="Search..." aria-label="Search">
      <button type="button">Search</button>
    </div>
  </div>

  <!-- Main Header -->
  <header>
    <div class="logo">
      <a href="index.php"><img src="image/UIU-Logo_Final-1-1024x351.png" alt="UIU Logo" loading="lazy"></a>
    </div>
    <!-- Hamburger toggle for mobile -->
    <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
    <nav class="main-nav" id="mainNav">
      <a href="index.php">Home</a>
      <a href="about.php">About</a>
      <a href="admission.php">Admission</a>
      <a href="academic.php">Academics</a>
      <a href="research.php">Research</a>
      <a href="student.php">Students</a>
      <a href="notices.php">Notices</a>
      <a href="contact.php">Contact</a>
    </nav>
  </header>

  <script>
    // Hamburger menu toggle
    document.getElementById('navToggle').addEventListener('click', function () {
      const nav = document.getElementById('mainNav');
      const expanded = this.getAttribute('aria-expanded') === 'true';
      this.setAttribute('aria-expanded', String(!expanded));
      nav.classList.toggle('open');
    });
  </script>