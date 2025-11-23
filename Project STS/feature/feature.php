<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/Project STS/home1/Main.css">
    <link rel="stylesheet" href="/Project STS/user.css">
    <link rel="stylesheet" href="feature.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    
<header>
  <nav>
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
    <button class="btn btn-blue"><a href="../login/login.php">Login</a></button>
  <?php endif; ?>
</header>

<section class="hero">
  <div class="hero-left">
    <h1>The all-in-one platform for Service-Oriented Business</h1>
    <p>Website, booking/payments, CRM and so much more.</p>
    <div class="hero-buttons">
      <button class="btn primary">Create an schedules</button>
      <button class="btn outline">See your revenue</button>
    </div>
  </div>
  <div class="hero-right">
    <img src="Gambar/Screenshot 2025-08-17 221558.png" alt="Hero Image">
  </div>
</section>

<section class="mid">

<div class="box">
    <div class="box-lef"></div>
    <div class="long-box">
</div>
</div>
<div class="bwh-box">
    <div class="box-rig"></div>
</div>
</section>
<div class="Line"></div>

</body>
</html>