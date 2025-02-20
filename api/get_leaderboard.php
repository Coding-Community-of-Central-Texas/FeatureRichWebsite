<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Import database credentials
require_once "../../config.php";

// Connect to MySQL
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

// Fetch leaderboard data and rank players based on best stats
$sql = "SELECT player_name, total_kills, quickest_time, longest_survival, total_cash
        FROM leaderboard 
        ORDER BY total_kills DESC, total_cash DESC, STR_TO_DATE(quickest_time, '%H:%i:%s.%f') ASC, 
                 STR_TO_DATE(longest_survival, '%H:%i:%s.%f') DESC
        LIMIT 50";  // Top 50 players

$result = $conn->query($sql);
$leaderboard = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $leaderboard[] = $row;
    }
}

$conn->close();
echo json_encode($leaderboard);
?>
