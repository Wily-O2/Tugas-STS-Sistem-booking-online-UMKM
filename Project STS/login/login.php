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

// Create users table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL UNIQUE,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === FALSE) {
    echo "Error creating table: " . $conn->error;
}

// Handle signup
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        if ($stmt->execute()) {
            $success = "Account created successfully. Please log in.";
        } else {
            $error = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);
    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            header("Location: ../Main.php"); // Redirect to main page after login
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Username not found.";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/gif/png" href="./images/Main Tab Image-Logo.png">
    <title>Responsive Login Slider</title>
</head>

<body>
    <div class="containter">
        <div class="bluebg">
            <div class="box signin">
                <h2>Already Have an Account?</h2>
                <button class="signinbtn">Sign In
                </button>
            </div>
            <div class="box signup">
                <h2>Don't Have an Account?</h2>
                <button class="signupbtn">Sign Up</button>
            </div>
        </div>
        <div class="formBx">
            <div class="form signinForm">
                <form method="POST" action="">
                    <i class='bx bx-log-in signinimage'></i>
                    <h3>Sign In</h3>
                    <?php if (isset($error) && isset($_POST['login'])) echo "<p style='color:red;'>$error</p>"; ?>
                    <input type="text" name="username" placeholder=" Username" required>
                    <input type="password" name="password" placeholder=" Password" required>
                    <input type="submit" name="login" value="Login">
                    <a href="https://www.alz.org/alzheimers-dementia/10_signs" class="forgot">Forgot Password?</a>
                </form>
            </div>
            <div class="form signupForm">
                <form method="POST" action="">
                    <i class='bx bxs-user signupimage'></i>
                    <h3>Sign Up</h3>
                    <?php if (isset($error) && isset($_POST['signup'])) echo "<p style='color:red;'>$error</p>"; ?>
                    <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
                    <input type="text" name="username" placeholder=" Username" required>
                    <input type="text" name="email" placeholder=" Email Address" required>
                    <input type="password" name="password" placeholder=" Password" required>
                    <input type="password" name="confirm_password" placeholder=" Confirm Password" required>
                    <input type="submit" name="signup" value="Register">
                </form>
            </div>
        </div>
    </div>
    <script src="login.js"></script>
</body>

</html>
