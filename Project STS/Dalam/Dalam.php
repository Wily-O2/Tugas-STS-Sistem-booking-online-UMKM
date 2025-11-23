<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "toura";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Fetch revenue data
$revenue_data = [];
$stmt = $conn->prepare("SELECT period, top_25, top_35, bottom_10, median FROM revenue_data WHERE user_id = ? ORDER BY period");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $revenue_data[$row['period']] = $row;
}
$stmt->close();

// Fetch growth rate data
$growth_data = [];
$stmt = $conn->prepare("SELECT period, rate FROM growth_rate WHERE user_id = ? ORDER BY period");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $growth_data[$row['period']] = $row['rate'];
}
$stmt->close();

$conn->close();

// Calculate max revenue for scaling
$max_revenue = 0;
foreach ($revenue_data as $data) {
    $max_revenue = max($max_revenue, $data['top_25'], $data['top_35'], $data['bottom_10'], $data['median']);
}
$max_revenue = max($max_revenue, 1000000); // At least 1M
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Revenue — Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="Dalam.css">
  <link rel="stylesheet" href="/Project STS/user.css">
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <!-- Top Navigation Header -->
  <header class="top-nav-header">
    <nav>
      <a href="../Main.php">Home</a>
      <a href="../produk/Product.php">Product</a>
      <a href="../About/about.php">About</a>
      <a href="../feature/feature.php">Features</a>
      <a href="../pricing/pricing.php">Pricing</a>
    </nav>
    <?php if (isset($_SESSION['user_id'])): ?>
      <div class="user-menu">
        <i class="bx bx-user user-icon"></i>
        <div class="dropdown-menu">
          <table>
            <tr><td><a href="../user.php">Profile</a></td></tr>
            <tr><td><a href="../user.php#settings">Settings</a></td></tr>
            <tr><td><a href="../login/logout.php">Logout</a></td></tr>
          </table>
        </div>
      </div>
    <?php else: ?>
      <button class="btn btn-blue"><a href="../login/login.php">Login</a></button>
    <?php endif; ?>
  </header>

  <!-- Revenue Header -->
  <header class="rd-header">
    <div class="rd-left">
      <h1 class="logo">⚛ Revenue</h1>
    </div>
    <div class="rd-right">
      <button class="download">⬇ Download</button>
      <div class="arr-dropdown">
        <button class="arr-button">$ Rp <?php echo number_format($max_revenue / 1000000, 1); ?>M ARR <span class="dropdown-arrow">▼</span></button>
      </div>
    </div>
  </header>

  <main class="rd-main">
    <!-- Top charts section -->
    <section class="charts-row">
      <aside class="controls-card">
        <div class="controls-inner">
          <div class="control-row">
            <label class="switch">
              <input type="checkbox" id="showLabels" checked>
              <span class="slider"></span>
            </label>
            <span>Show Chart Labels</span>
          </div>

          <div class="control-row">
            <label class="switch">
              <input type="checkbox" id="overlayMetrics">
              <span class="slider"></span>
            </label>
            <span>Overlay Your Account Metrics</span>
          </div>

          <div class="legend">
            <div class="legend-item"><span class="dot red"></span> Top 25%</div>
            <div class="legend-item"><span class="dot purple"></span> Top 35%</div>
            <div class="legend-item"><span class="dot green"></span> Bottom 10%</div>
            <div class="legend-item"><span class="dot blue"></span> Median</div>
          </div>
        </div>
      </aside>

      <section class="big-chart">
        <div class="big-chart-header">
          <h2>Revenue</h2>
          <div class="y-axis-labels" id="yAxisLabels">
            <div>Rp <?php echo number_format($max_revenue, 0, ',', '.'); ?></div>
            <div>Rp <?php echo number_format($max_revenue * 0.75, 0, ',', '.'); ?></div>
            <div>Rp <?php echo number_format($max_revenue * 0.5, 0, ',', '.'); ?></div>
            <div>Rp <?php echo number_format($max_revenue * 0.25, 0, ',', '.'); ?></div>
            <div>Rp 0</div>
          </div>
        </div>

        <div class="bars-area" id="barsArea">
          <?php
          for ($i = 1; $i <= 5; $i++) {
              $data = isset($revenue_data[$i]) ? $revenue_data[$i] : ['top_25' => 0, 'top_35' => 0, 'bottom_10' => 0, 'median' => 0];
              $height_top_25 = ($data['top_25'] / $max_revenue) * 240;
              $height_top_35 = ($data['top_35'] / $max_revenue) * 240;
              $height_bottom_10 = ($data['bottom_10'] / $max_revenue) * 240;
              $height_median = ($data['median'] / $max_revenue) * 240;
          ?>
          <div class="bar-group" data-period="<?php echo $i; ?>">
            <div class="bar green" style="height: <?php echo max($height_top_25, 5); ?>px; background: #57d27a;" 
                 data-value="<?php echo $data['top_25']; ?>" 
                 data-type="top_25" 
                 data-period="<?php echo $i; ?>"
                 title="Top 25%: Rp <?php echo number_format($data['top_25'], 0, ',', '.'); ?>"></div>
            <div class="bar red" style="height: <?php echo max($height_top_35, 5); ?>px; background: #f76c6c;" 
                 data-value="<?php echo $data['top_35']; ?>" 
                 data-type="top_35" 
                 data-period="<?php echo $i; ?>"
                 title="Top 35%: Rp <?php echo number_format($data['top_35'], 0, ',', '.'); ?>"></div>
            <div class="bar purple" style="height: <?php echo max($height_bottom_10, 5); ?>px; background: #a77bf7;" 
                 data-value="<?php echo $data['bottom_10']; ?>" 
                 data-type="bottom_10" 
                 data-period="<?php echo $i; ?>"
                 title="Bottom 10%: Rp <?php echo number_format($data['bottom_10'], 0, ',', '.'); ?>"></div>
            <div class="bar blue" style="height: <?php echo max($height_median, 5); ?>px; background: #6caaf3;" 
                 data-value="<?php echo $data['median']; ?>" 
                 data-type="median" 
                 data-period="<?php echo $i; ?>"
                 title="Median: Rp <?php echo number_format($data['median'], 0, ',', '.'); ?>"></div>
            <div class="period-label"><?php echo $i; ?></div>
          </div>
          <?php } ?>
        </div>
      </section>
    </section>

    <!-- Recurring Revenue Growth Rate -->
    <section class="recurring-section">
      <h2 class="section-title">Recurring Revenue Growth Rate</h2>

      <div class="recurring-chart" id="growthChart">
        <?php
        $max_growth = max(array_merge($growth_data, [22]));
        for ($i = 1; $i <= 10; $i++) {
            $rate = isset($growth_data[$i]) ? $growth_data[$i] : 0;
            $height = ($rate / $max_growth) * 200;
        ?>
        <div class="rec-bar" 
             style="height: <?php echo $height; ?>px;" 
             data-period="<?php echo $i; ?>"
             data-rate="<?php echo $rate; ?>"
             title="Period <?php echo $i; ?>: <?php echo number_format($rate, 1); ?>%"></div>
        <?php } ?>
      </div>
      <div class="rec-xlabels">
        <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span><span>6</span><span>7</span><span>8</span><span>9</span><span>10</span>
      </div>
    </section>

    <!-- CTA -->
    <section class="cta">
      <h3>Get Started Today</h3>
      <p>Want To See More Unlock It With Our Best Plan</p>
      <button class="subscribe">Subscribe</button>
    </section>

  </main>

  <!-- Edit Modal -->
  <div id="editModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h3>Edit Revenue Data</h3>
      <form id="editForm">
        <input type="hidden" id="editPeriod" name="period">
        <input type="hidden" id="editType" name="type">
        <div class="form-group">
          <label id="editLabel">Value:</label>
          <input type="number" id="editValue" name="value" step="0.01" required>
        </div>
        <button type="submit" class="btn-save">Save</button>
      </form>
    </div>
  </div>

  <footer class="rd-footer">
    <small>© 2025 Revenue UI — Dashboard</small>
  </footer>

  <script src="Dalam.js"></script>
</body>
</html>

