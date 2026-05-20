<?php
include 'db_connect.php';
$noticeResult = $conn->query("SELECT * FROM notices ORDER BY date DESC");
$eventResult = $conn->query("SELECT * FROM events ORDER BY date DESC");
$pageTitle = 'UIU Clone – Home';
include 'includes/header.php';
?>

<!-- Hero Slideshow -->
<div class="slideshow">
  <input type="radio" name="slider" id="slide1" checked>
  <input type="radio" name="slider" id="slide2">
  <input type="radio" name="slider" id="slide3">
  <div class="slides">
    <div class="slide"><img src="image/BC4.jpg" alt="UIU Campus" loading="eager"></div>
    <div class="slide"><img src="image/gradute.webp" alt="Graduation" loading="lazy"></div>
    <div class="slide"><img src="image/sprin2025.jpg" alt="Spring 2025" loading="lazy"></div>
  </div>
  <div class="hero-content">
    <p>Admission Open Summer 2025 Trimester</p>
    <h1>United International University</h1>
    <a href="apply_online.php"><button>Apply Now</button></a>
  </div>
  <div class="arrow left-arrow">
    <label for="slide3" class="to-s1">&#10094;</label>
    <label for="slide1" class="to-s2">&#10094;</label>
    <label for="slide2" class="to-s3">&#10094;</label>
  </div>
  <div class="arrow right-arrow">
    <label for="slide2" class="to-s1">&#10095;</label>
    <label for="slide3" class="to-s2">&#10095;</label>
    <label for="slide1" class="to-s3">&#10095;</label>
  </div>
</div>

<!-- About -->
<section class="about-section">
  <div class="section-wrap">
    <h2>Quest For Excellence</h2>
    <p>The mission of UIU is to create excellent human resources with intellectual, creative, technical, moral and
      practical skills to serve community, industry and region.</p>
    <a href="coming_soon.php"><button>More About UIU</button></a>
  </div>
</section>

<!-- Admission -->
<section class="admission-section">
  <div class="section-wrap">
    <h2>Admission</h2>
    <p>UIU offers a comprehensive admission process, welcoming students into diverse programs that foster academic
      growth and real-world skills.</p>
    <div class="admission-cards">
      <div class="card">
        <img src="image/sprin2025.jpg" alt="Undergraduate" loading="lazy">
        <h4>Undergraduate Programs</h4>
        <p>UIU offers 12 undergraduate programs from 3 different schools.</p>
        <a href="ungad.php"><button>Undergraduate Programs</button></a>
      </div>
      <div class="card">
        <img src="image/gradute.webp" alt="Graduate" loading="lazy">
        <h4>Graduate Programs</h4>
        <p>UIU offers 6 graduate programs from 3 different schools.</p>
        <a href="ungad.php"><button>Graduate Programs</button></a>
      </div>
      <div class="card">
        <img src="image/download2.jpeg" alt="Continuing Education" loading="lazy">
        <h4>Continuing Education</h4>
        <p>From different centers and institutes UIU offers over 40 short professional courses.</p>
        <button>Continuing Education</button>
      </div>
    </div>
    <div class="more-admission"><button>More About Admission</button></div>
  </div>
</section>

<!-- Recognition -->
<section class="recognition-section">
  <div class="section-wrap">
    <h2>Recognition</h2>
    <p>United International University is recognized nationally and globally for excellence in teaching and research,
      reflected through its prestigious rankings.</p>
  </div>
</section>

<!-- Notices -->
<section class="notices">
  <div class="container">
    <h2>Notices</h2>
    <p class="notice-description">Stay Updated: Explore the Latest Notices from UIU for Key Information on Academic
      Schedules, Upcoming Events, and Essential University Announcements.</p>
    <div class="notice-grid">
      <?php if ($noticeResult && $noticeResult->num_rows > 0): ?>
        <?php while ($row = $noticeResult->fetch_assoc()): ?>
          <div class="notice-item">
            <span>&#128197; <?= date('F d, Y', strtotime($row['date'])) ?></span>
            <p><?= htmlspecialchars($row['title']) ?></p>
            <?php if (!empty($row['pdf_file'])): ?>
              <a href="<?= htmlspecialchars($row['pdf_file']) ?>" target="_blank" rel="noopener">&#128196; View PDF</a>
            <?php endif; ?>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No notices found.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Events -->
<section class="events-section">
  <h2>Events</h2>
  <p>Explore UIU's vibrant campus life: upcoming events, workshops, and gatherings to connect, learn, and grow.</p>
  <div class="event-grid">
    <?php if ($eventResult && $eventResult->num_rows > 0): ?>
      <?php while ($row = $eventResult->fetch_assoc()):
        $words = explode(' ', $row['description']);
        $uid = 'evt_' . (int) $row['id'];
        $isLong = count($words) > 10;
        ?>
        <div class="event-item">
          <h3><?= htmlspecialchars($row['title']) ?></h3>
          <span>&#128197; <?= htmlspecialchars($row['date']) ?></span>
          <?php if ($isLong): ?>
            <p id="<?= $uid ?>-s"><?= htmlspecialchars(implode(' ', array_slice($words, 0, 10))) ?>&#8230; <a href="#"
                onclick="toggleDesc('<?= $uid ?>');return false;">See more</a></p>
            <p id="<?= $uid ?>-f" style="display:none"><?= htmlspecialchars($row['description']) ?> <a href="#"
                onclick="toggleDesc('<?= $uid ?>');return false;">See less</a></p>
          <?php else: ?>
            <p><?= htmlspecialchars($row['description']) ?></p>
          <?php endif; ?>
          <?php if (!empty($row['image'])): ?>
            <a href="<?= htmlspecialchars($row['image']) ?>" target="_blank" rel="noopener">
              <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>" loading="lazy">
            </a>
          <?php endif; ?>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p style="grid-column:1/-1;text-align:center">No events found.</p>
    <?php endif; ?>
  </div>
</section>

<script>
  function toggleDesc(id) {
    var s = document.getElementById(id + '-s'), f = document.getElementById(id + '-f');
    if (!s || !f) return;
    var show = s.style.display !== 'none';
    s.style.display = show ? 'none' : 'block';
    f.style.display = show ? 'block' : 'none';
  }
</script>

<?php include 'includes/footer.php'; ?>