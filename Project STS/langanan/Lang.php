<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "toura";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

// Handle subscription
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['subscribe'])) {
    $plan_name = $_POST['plan_name'];
    $price = $_POST['price'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO subscriptions (user_id, plan_name, price) VALUES (?, ?, ?)");
    $stmt->bind_param("isd", $user_id, $plan_name, $price);
    if ($stmt->execute()) {
        $success = "Subscription successful!";
    } else {
        $error = "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
    <link rel="stylesheet" href="/Project STS/home1/Main.css">
    <link rel="stylesheet" href="/Project STS/user.css">
    <link rel="stylesheet" href="Lang.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
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
  <main> 
<div class="Lang-Header">
    <h1>Simple Pricing</h1>
    <h3>Get all of Toura Power for a fraction of the cost of the alternatives.</h3>
</div>
<div class="bulletin">
  <div class="bulletin-row">
    <h3><img src="check-icon.png" alt=""> Pay as you go plans</h3>
    <h3><img src="check-icon.png" alt=""> No Hidden Fees</h3>
    <h3><img src="check-icon.png" alt=""> All-Inclusive Features</h3>
  </div>
  <div class="bulletin-row bottom">
    <h3><img src="check-icon.png" alt=""> Easy Cancellation Policy</h3>
    <h3><img src="check-icon.png" alt=""> 24/7 Support</h3>
  </div>
</div>

<div class="Sch-Gradient">
    <h1>SchedulePro Pricing</h1>
</div>
    <div class="Lang-mid">
    <p>The optimal solution for SMBs offering services. Designed to seamlessly streamline bookings, facilitate payments, and enhance customer relationships.</p>
    </div>

<div class="pricing-section">
  <div class="billing-toggle">
    <span class="billing-label">Billed Annually</span>
    <button class="toggle-switch" aria-pressed="false" title="Toggle billing">
      <span class="knob"></span>
    </button>
    <span class="billing-label">Billed Monthly</span>
  </div>

  <!-- Cards container -->
  <div class="pricing-cards">
    <!-- Left card -->
    <div class="pricing-card">
      <div class="card-inner">
        <h3 class="card-title">Schedule Pro V1</h3>
        <ul class="card-features">
          <li>Automatic Schedule<br>Management</li>
          <li>Automatic Notifications</li>
          <li>Analytics Dashboard</li>
        </ul>

        <div class="card-footer">
          <form method="POST" action="">
            <input type="hidden" name="plan_name" value="Schedule Pro V1">
            <input type="hidden" name="price" value="0.80">
            <button type="submit" name="subscribe" class="btn-subscribe">Subscribe</button>
          </form>
          <div class="price">$ 0.80</div>
        </div>
      </div>
    </div>

    <!-- Center featured card -->
    <div class="pricing-card pricing-card--featured">
      <div class="featured-topbar"></div>
      <div class="card-inner">
        <h3 class="card-title">Schedule Pro V2</h3>
        <ul class="card-features">
          <li>Automatic Schedule<br>Management</li>
          <li>Automatic Notifications</li>
          <li>Analytics Dashboard</li>
        </ul>

        <div class="card-footer">
          <button class="btn-subscribe btn-subscribe--filled">Subscribe</button>
          <div class="price price--large">$ 1.22</div>
        </div>
      </div>
      <div class="featured-bottombar"></div>
    </div>

    <!-- Right card -->
    <div class="pricing-card">
      <div class="card-inner">
        <h3 class="card-title">Schedule Pro V3</h3>
        <ul class="card-features">
          <li>Automatic Schedule<br>Management</li>
          <li>Automatic Notifications</li>
          <li>Analytics Dashboard</li>
        </ul>

        <div class="card-footer">
          <form method="POST" action="">
            <input type="hidden" name="plan_name" value="Schedule Pro V3">
            <input type="hidden" name="price" value="2.40">
            <button type="submit" name="subscribe" class="btn-subscribe">Subscribe</button>
          </form>
          <div class="price">$ 2.40</div>
        </div>
      </div>
    </div>
  </div>
</div>


  </main>
</body>
</html>