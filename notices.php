<?php
include 'db_connect.php';
$sql    = "SELECT * FROM notices ORDER BY date DESC";
$result = $conn->query($sql);
$pageTitle = 'Notices – UIU';
include 'includes/header.php';
?>

  <section class="notices-section">
    <div class="container">
      <h1>Notices</h1>
      <div class="notice-intro">
        <div class="notice-text">
          <p>Stay Updated: Explore the Latest Notices from UIU for Key Information on Academic Schedules, Upcoming Events, and Essential University Announcements. Keep Informed, Stay Ahead!</p>
        </div>
        <div class="notice-img">
          <img src="image/campus_07.jpg" alt="UIU Campus" loading="lazy">
        </div>
      </div>

      <div class="notice-grid">
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
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

<?php include 'includes/footer.php'; ?>
