<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "toura";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SHOW TABLES");
$tables = [];
while ($row = $result->fetch_array()) {
    $tables[] = $row[0];
}

echo "Tables in toura database:\n";
foreach ($tables as $table) {
    echo "- $table\n";
}

$conn->close();
?>
