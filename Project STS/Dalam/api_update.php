<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Not authenticated']);
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "toura";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit();
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['type'])) {
    if ($data['type'] === 'revenue') {
        $period = intval($data['period']);
        $top_25 = floatval($data['top_25']);
        $top_35 = floatval($data['top_35']);
        $bottom_10 = floatval($data['bottom_10']);
        $median = floatval($data['median']);
        
        $stmt = $conn->prepare("INSERT INTO revenue_data (user_id, period, top_25, top_35, bottom_10, median) 
                               VALUES (?, ?, ?, ?, ?, ?) 
                               ON DUPLICATE KEY UPDATE top_25=VALUES(top_25), top_35=VALUES(top_35), 
                               bottom_10=VALUES(bottom_10), median=VALUES(median)");
        $stmt->bind_param("iidddd", $user_id, $period, $top_25, $top_35, $bottom_10, $median);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }
        $stmt->close();
    } elseif ($data['type'] === 'growth_rate') {
        $period = intval($data['period']);
        $rate = floatval($data['rate']);
        
        $stmt = $conn->prepare("INSERT INTO growth_rate (user_id, period, rate) 
                               VALUES (?, ?, ?) 
                               ON DUPLICATE KEY UPDATE rate=VALUES(rate)");
        $stmt->bind_param("iid", $user_id, $period, $rate);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid type']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Missing type']);
}

$conn->close();
?>


