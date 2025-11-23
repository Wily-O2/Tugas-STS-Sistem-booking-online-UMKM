<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Toura</title>
  <link rel="stylesheet" href="/Project STS/home1/Main.css">
  <link rel="stylesheet" href="/Project STS/user.css">
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

  <header>
    <nav>
      <a href="Main.php">Home</a>
      <a href="produk/Product.php">Product</a>
      <a href="About/about.php">About</a>
      <a href="feature/feature.php">Features</a>
      <a href="pricing/pricing.php">Pricing</a>
    </nav>
    <?php if (isset($_SESSION['user_id'])): ?>
      <div class="user-menu">
        <i class="bx bx-user user-icon"></i>
        <div class="dropdown-menu">
          <table>
            <tr><td><a href="user.php">Profile</a></td></tr>
            <tr><td><a href="user.php#settings">Settings</a></td></tr>
            <tr><td><a href="login/logout.php">Logout</a></td></tr>
          </table>
        </div>
      </div>
    <?php else: ?>
      <a href="login/login.php" class="btn btn-blue">Login</a>
    <?php endif; ?>
  </header>

  <section class="hero">
    <h1>⚛ Toura</h1>
    <p>
      The all-in-one platform for Service Oriented Business. Website, bookings, payments, CRM and so much more
    </p>
    <div class="hero-buttons">
      <button class="btn btn-blue">Start Free Trial</button>
      <button class="btn btn-outline">Watch How It Works</button>
    </div>
  </section>

  <section class="section">
    <h2>Getting started Guide</h2>
    <div class="cards">
      <div class="card"><span>Start Here</span></div>
      <div class="card"><span>Start Here</span></div>
      <div class="card"><span>Start Here</span></div>
    </div>
  </section>

  <section class="section">
    <h2>Set Up Your Digital Platform</h2>
    <div class="cards">
      <div class="card"><span>Website</span></div>
      <div class="card"><span>Booking Form</span></div>
    </div>
  </section>

  <section class="section">
    <h2>Manage bookings and payments</h2>
    <div class="cards">
      <div class="card"><span>Order</span></div>
      <div class="card"><span>Payment</span></div>
    </div>
  </section>

  <div class="teks">
    <h2>Powerful Business Tools Made Simple</h2>
  </div>

<section class="gallery">
  <img src="Gambar/login.png" alt="Gallery 1">
  <img src="Gambar/login.png" alt="Gallery 2">
  <img src="Gambar/login.png" alt="Gallery 3">
</section>

<section class="form-section">
    <div class="icon">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" 
              d="M12 6v6l4 2m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </div>
    <h2>Create an Account</h2>
    <p>Enter your email and choose a username</p>
    <form>
      <input type="email" placeholder="Email" required>
      <input type="text" placeholder="Choose a username" required>
      <button type="submit">Create Your Free Account</button>
    </form>
  </section>

  <section class="text-section">
    <h3>Toura suite of products was made to grow Entrepreneurs and Service SMBs</h3>
    <p>
      Revolutionalize how you manage bookings, schedules, orders, and customer relations, 
      all in one powerful tool. Transform your business operations to leverage tech for growth 
      and automate your success.
    </p>
  </section>

  <div class="bottom-images">
    <img src="../Gambar/Home Page/16+ Serene Zen Office Ideas for a Peaceful Workspace" alt="bottom1">
    <img src="https://source.unsplash.com/300x200/?laptop" alt="bottom2">
    <img src="https://source.unsplash.com/300x200/?office" alt="bottom3">
    
    <div class="manage-right">
      <div class="manage-card">
        <h3>Order Manager</h3>
        <p>Track and fulfill all your customer requests with ease.</p>
      </div>
      <div class="manage-card">
        <h3>Secure Payments</h3>
        <p>Enable trusted payment options to keep transactions smooth and safe.</p>
      </div>
    </div>
  </div>
</section>
<footer>
  <p>&copy; 2024 Toura. All rights reserved.</p>
<script src="/Project STS/home1/Main.js"></script>
</body>
</html>
