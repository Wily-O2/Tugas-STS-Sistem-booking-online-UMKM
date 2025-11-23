<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.php");
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
$message = '';

// Fetch user data (handle missing columns gracefully)
$stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Check if new columns exist and fetch them if they do
$columns_check = $conn->query("SHOW COLUMNS FROM users LIKE 'first_name'");
if ($columns_check->num_rows > 0) {
    $stmt = $conn->prepare("SELECT first_name, last_name, profile_picture FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $additional_data = $result->fetch_assoc();
    $user = array_merge($user, $additional_data ?: []);
    $stmt->close();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    
    // Check if columns exist, if not, add them
    $columns_check = $conn->query("SHOW COLUMNS FROM users LIKE 'first_name'");
    if ($columns_check->num_rows == 0) {
        $conn->query("ALTER TABLE users ADD COLUMN first_name VARCHAR(100) DEFAULT NULL");
        $conn->query("ALTER TABLE users ADD COLUMN last_name VARCHAR(100) DEFAULT NULL");
        $conn->query("ALTER TABLE users ADD COLUMN profile_picture VARCHAR(255) DEFAULT NULL");
    }
    
    $columns_check = $conn->query("SHOW COLUMNS FROM users LIKE 'first_name'");
    if ($columns_check->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE id = ?");
        $stmt->bind_param("sssi", $first_name, $last_name, $email, $user_id);
    } else {
        // Fallback: only update email if columns don't exist
        $stmt = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
        $stmt->bind_param("si", $email, $user_id);
    }
    
    if ($stmt->execute()) {
        $message = "Account settings updated successfully!";
        // Refresh user data
        $stmt2 = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
        $stmt2->bind_param("i", $user_id);
        $stmt2->execute();
        $result = $stmt2->get_result();
        $user = $result->fetch_assoc();
        $stmt2->close();
        
        // Get additional fields if they exist
        $columns_check = $conn->query("SHOW COLUMNS FROM users LIKE 'first_name'");
        if ($columns_check->num_rows > 0) {
            $stmt3 = $conn->prepare("SELECT first_name, last_name, profile_picture FROM users WHERE id = ?");
            $stmt3->bind_param("i", $user_id);
            $stmt3->execute();
            $result = $stmt3->get_result();
            $additional_data = $result->fetch_assoc();
            $user = array_merge($user, $additional_data ?: []);
            $stmt3->close();
        }
    } else {
        $message = "Error updating account: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();

$first_name = $user['first_name'] ?? '';
$last_name = $user['last_name'] ?? '';
$email = $user['email'] ?? '';
$profile_picture = $user['profile_picture'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Account Settings - Toura</title>
  <link rel="stylesheet" href="/Project STS/home1/Main.css">
  <link rel="stylesheet" href="/Project STS/user.css">
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="user-page">
  <!-- Top Navigation Header -->
  <header class="top-nav-header">
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

  <div class="user-container">
    <!-- Left Sidebar -->
    <aside class="sidebar">
      <a href="Main.php" class="back-link">
        <i class='bx bx-arrow-back'></i> Back
      </a>
      <nav class="sidebar-nav">
        <a href="user.php" class="nav-item active">
          <i class='bx bx-user'></i>
          <span>Account</span>
        </a>
        <a href="Dalam/Dalam.php" class="nav-item">
          <i class='bx bx-line-chart'></i>
          <span>Your Revenue</span>
        </a>
        <a href="#" class="nav-item">
          <i class='bx bx-calendar'></i>
          <span>Calendar</span>
        </a>
        <a href="langanan/Lang.php" class="nav-item">
          <i class='bx bx-grid-alt'></i>
          <span>Your Subscription</span>
        </a>
      </nav>
    </aside>

    <!-- Main Content Area -->
    <main class="main-content">
      <div class="content-header">
        <div class="header-icon">
          <i class='bx bx-user'></i>
        </div>
        <div class="header-text">
          <h1>Account Settings</h1>
          <p>Here You can update information about your account.</p>
        </div>
      </div>

      <?php if ($message): ?>
        <div class="message <?php echo strpos($message, 'Error') !== false ? 'error' : 'success'; ?>">
          <?php echo htmlspecialchars($message); ?>
        </div>
      <?php endif; ?>

      <!-- Profile Picture Section -->
      <div class="profile-picture-section">
        <div class="profile-image">
          <?php if ($profile_picture): ?>
            <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture">
          <?php else: ?>
            <div class="profile-placeholder">
              <i class='bx bx-user'></i>
            </div>
          <?php endif; ?>
        </div>
        <div class="profile-info">
          <p>Update a profile picture to personalize your workspace and help collaborators identify you.</p>
          <p class="recommendation">The recommended size is 400 x 400 and less than 1 mb.</p>
        </div>
      </div>

      <!-- Account Settings Form -->
      <form method="POST" action="" class="account-form">
        <div class="form-row">
          <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" placeholder="Enter first name">
          </div>
          <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" placeholder="Enter last name">
          </div>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Enter email address">
        </div>
        <button type="submit" name="save" class="save-btn">Save</button>
      </form>
    </main>
  </div>
</body>
</html>

