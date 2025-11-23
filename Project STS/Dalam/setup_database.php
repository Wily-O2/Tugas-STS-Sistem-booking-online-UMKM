<?php
// Database setup script for Dalam revenue dashboard
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "toura";

$conn = new mysqli($servername, $username, $password);

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
$conn->query($sql);
$conn->select_db($dbname);

// Create revenue_data table
$sql = "CREATE TABLE IF NOT EXISTS revenue_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    period INT NOT NULL,
    top_25 DECIMAL(10,2) DEFAULT 0,
    top_35 DECIMAL(10,2) DEFAULT 0,
    bottom_10 DECIMAL(10,2) DEFAULT 0,
    median DECIMAL(10,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_period (user_id, period)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table revenue_data created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Create growth_rate table
$sql = "CREATE TABLE IF NOT EXISTS growth_rate (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    period INT NOT NULL,
    rate DECIMAL(5,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_period (user_id, period)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table growth_rate created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Insert default data for user_id 1 (or current user)
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;

// Insert default revenue data (5 periods)
for ($i = 1; $i <= 5; $i++) {
    $top_25 = rand(150000, 200000);
    $top_35 = rand(100000, 150000);
    $bottom_10 = rand(30000, 60000);
    $median = rand(70000, 120000);
    
    $stmt = $conn->prepare("INSERT INTO revenue_data (user_id, period, top_25, top_35, bottom_10, median) 
                           VALUES (?, ?, ?, ?, ?, ?) 
                           ON DUPLICATE KEY UPDATE top_25=VALUES(top_25), top_35=VALUES(top_35), 
                           bottom_10=VALUES(bottom_10), median=VALUES(median)");
    $stmt->bind_param("iidddd", $user_id, $i, $top_25, $top_35, $bottom_10, $median);
    $stmt->execute();
}

// Insert default growth rate data (10 periods)
for ($i = 1; $i <= 10; $i++) {
    $rate = rand(5, 22);
    $stmt = $conn->prepare("INSERT INTO growth_rate (user_id, period, rate) 
                           VALUES (?, ?, ?) 
                           ON DUPLICATE KEY UPDATE rate=VALUES(rate)");
    $stmt->bind_param("iid", $user_id, $i, $rate);
    $stmt->execute();
}

echo "Database setup completed!<br>";
echo "<a href='Dalam.php'>Go to Dashboard</a>";

$conn->close();
?>


