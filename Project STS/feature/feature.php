<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Landing — Demo</title>
  <link rel="stylesheet" href="feature.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
</head>
<body>
<header class="site-header">
  <nav class="nav">
    <a href="../Main.php">Home</a>
    <a href="../produk/Product.php">Product</a>
    <a href="../About/about.php">About</a>
    <a href="feature.php">Features</a>
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
    <button class="login-btn">
      <a href="../login/login.php">Login</a>
    </button>
  <?php endif; ?>
</header>


  <main>
    <section class="hero container">
      <div class="hero-left">
        <h1>Find an Better Solution<br/>For Your Business</h1>
        <p class="lead">
          The all-in-one platform for Service Oriented
          Business. Website, bookings, payments, CRM and so much more
        </p>

        <div class="hero-cta">
          <a class="btn primary" href="#">Start now - it's free</a>
          <a class="btn ghost" href="#">Watch how its works</a>
        </div>

        <div class="stats-grid">
          <div class="card stat-card">
            <div class="chart">New Leads
              <div class="bar-graphic">
                <div class="bar" style="height:64%"></div>
                <div class="bar" style="height:84%"></div>
                <div class="bar" style="height:100%"></div>
                <div class="bar" style="height:76%"></div>
              </div>
            </div>
          </div>

          <div class="card stat-card large-text">
            <h3>2.5 K+</h3>
            <p class="small">Thanks for all of the support<br/>An Customer good review will help us go stronger and better every time</p>
          </div>

          <div class="card stat-card info">
            <h3>Our Progress &amp; Marketing Analysis</h3>
            <p>Every customer review strengthens our marketing reach. Honest feedback guides improvements and boosts brand visibility.</p>
          </div>
        </div>
      </div>

      <div class="hero-right">
        <!-- use provided image path (will be transformed to proper url by the system) -->
        <div class="image-card">
          <img src="/mnt/data/e9504af3-3376-4f4d-aba4-1d5a042a6f7b.png" alt="hero" />
        </div>
      </div>
    </section>

    <hr class="section-divider container"/>

    <!-- VERTICAL TIMELINE / SECOND SECTION -->
    <section class="timeline container">
      <h2 class="section-title">Our Latest System</h2>

      <div class="timeline-inner">
        <div class="timeline-item left">
          <div class="circle-img"><img src="/mnt/data/25fc0f55-af4f-4515-ba1b-e973dd3d4699.png" alt="img1"></div>
          <div class="bubble">
            <h4>Instant &amp; Scheduled Booking</h4>
            <p>Customers can order services or products directly (real-time) or schedule them according to their needs.</p>
          </div>
        </div>

        <div class="timeline-item right">
          <div class="bubble">
            <h4>Automatic Schedule Management</h4>
            <p>MSMEs don't need to worry about manual record-keeping. All order schedules are neatly recorded in an easy-to-monitor digital calendar.</p>
          </div>
          <div class="circle-img"><img src="/mnt/data/25fc0f55-af4f-4515-ba1b-e973dd3d4699.png" alt="img2"></div>
        </div>

        <div class="timeline-item left">
          <div class="circle-img"><img src="/mnt/data/25fc0f55-af4f-4515-ba1b-e973dd3d4699.png" alt="img3"></div>
          <div class="bubble">
            <h4>Automatic Notifications</h4>
            <p>Automatic reminders via email, WhatsApp, or SMS so customers and business owners don't miss schedules.</p>
          </div>
        </div>

        <div class="timeline-item right">
          <div class="bubble">
            <h4>Product / Service Profile &amp; Catalog</h4>
            <p>MSMEs can display their business profile, service list, product menu, prices, and special promotions on one page.</p>
          </div>
          <div class="circle-img"><img src="/mnt/data/25fc0f55-af4f-4515-ba1b-e973dd3d4699.png" alt="img4"></div>
        </div>
      </div>
    </section>

    <footer class="site-footer">
      <div class="container footer-grid">
        <div class="logo-row">
          <div class="brand">Toura</div>
        </div>
        <div class="footer-col">
          <h5>Tentang Toura</h5>
          <ul>
            <li>Bantuan</li>
            <li>Hubungi Kami</li>
            <li>Cara Pesan</li>
            <li>Tentang Kami</li>
          </ul>
        </div>
        <div class="footer-col">
          <h5>Follow Kami di</h5>
          <ul>
            <li>Facebook</li>
            <li>Youtube</li>
            <li>WhatsApp</li>
            <li>Telegram</li>
          </ul>
        </div>
        <div class="footer-col">
          <h5>Lainnya</h5>
          <ul>
            <li>Syarat &amp; Ketentuan</li>
            <li>Pengembalian</li>
            <li>Blog</li>
            <li>FAQ</li>
          </ul>
        </div>
      </div>
    </footer>
  </main>
</body>
</html>
