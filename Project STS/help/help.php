<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Toura</title>
  <link rel="stylesheet" href="/Project STS/home1/Main.css">
  <link rel="stylesheet" href="/Project STS/user.css">
  <link rel="stylesheet" href="help.css">
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<div class="Head">
  <header>
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
</div>

    <section class="hero">
        <div class="hero-content">
            <h1>Hi. How can we Help</h1>
            <div class="search-container">
                <input type="text" class="search-box" placeholder="Search...">
            </div>
            <div class="search-hint">
                Common troubleshooting topics: Notification, Calendar and how its <br>works
            </div>
        </div>
    </section>

    <section>
      <div class="Notifikasi">
        (Notification)How can i know <br>my payment went smoothly
      </div>

      <div class="Notif">
        (Notification)Why can’t I receive <br>a notification from Checkout?
      </div>

      <div class="Help">
        Need More Help? Contact us
      </div>

      <div class="Email">
        Email: TouraOrg@gmail.com <br>
        Number: 0877-9872-1111
      </div>

      <div class="card"></div>
    </section>

   

 

</body>