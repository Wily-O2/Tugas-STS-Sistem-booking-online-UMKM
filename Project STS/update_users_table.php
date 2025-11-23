<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "toura";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$columns = [
    "ALTER TABLE users ADD COLUMN IF NOT EXISTS first_name VARCHAR(100) DEFAULT NULL",
    "ALTER TABLE users ADD COLUMN IF NOT EXISTS last_name VARCHAR(100) DEFAULT NULL",
    "ALTER TABLE users ADD COLUMN IF NOT EXISTS profile_picture VARCHAR(255) DEFAULT NULL"
];

foreach ($columns as $sql) {
    $result = $conn->query("SHOW COLUMNS FROM users LIKE 'first_name'");
    if ($result->num_rows == 0) {
        $conn->query("ALTER TABLE users ADD COLUMN first_name VARCHAR(100) DEFAULT NULL");
        echo "Added first_name column<br>";
    }
    
    $result = $conn->query("SHOW COLUMNS FROM users LIKE 'last_name'");
    if ($result->num_rows == 0) {
        $conn->query("ALTER TABLE users ADD COLUMN last_name VARCHAR(100) DEFAULT NULL");
        echo "Added last_name column<br>";
    }
    
    $result = $conn->query("SHOW COLUMNS FROM users LIKE 'profile_picture'");
    if ($result->num_rows == 0) {
        $conn->query("ALTER TABLE users ADD COLUMN profile_picture VARCHAR(255) DEFAULT NULL");
        echo "Added profile_picture column<br>";
    }
}

echo "Users table updated successfully!<br>";
echo "<a href='user.php'>Go to User Page</a>";

$conn->close();
?>

