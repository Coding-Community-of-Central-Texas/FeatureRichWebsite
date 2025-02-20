<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");


require_once "../../config.php";


$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}


$input = file_get_contents("php://input");
$data = json_decode($input, true);


$headers = getallheaders();
$provided_key = isset($headers["X-API-KEY"]) ? $headers["X-API-KEY"] : null;
if (!$provided_key || $provided_key !== API_KEY) {
    echo json_encode(["error" => "Unauthorized - Invalid API key"]);
    http_response_code(401); // 401 Unauthorized
    exit;
}


if (!$data || !isset($data["player_name"])) {
    echo json_encode(["error" => "Invalid JSON data"]);
    exit;
}


$player_name = htmlspecialchars(trim($data["player_name"]), ENT_QUOTES, 'UTF-8'); 
$total_kills = (int) $data["total_kills"];
$quickest_time = $conn->real_escape_string($data["quickest_time"]);
$longest_survival = $conn->real_escape_string($data["longest_survival"]);
$total_cash = (int) $data["total_cash"];


$stmt = $conn->prepare("SELECT * FROM leaderboard WHERE player_name = ?");
$stmt->bind_param("s", $player_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    
    $stmt = $conn->prepare("UPDATE leaderboard 
        SET total_kills = GREATEST(total_kills, ?),
            total_cash = GREATEST(total_cash, ?),
            quickest_time = LEAST(quickest_time, ?),
            longest_survival = GREATEST(longest_survival, ?)
        WHERE player_name = ?");
    $stmt->bind_param("iisss", $total_kills, $total_cash, $quickest_time, $longest_survival, $player_name);
    $stmt->execute();
} else {
    
    $stmt = $conn->prepare("INSERT INTO leaderboard (player_name, total_kills, quickest_time, longest_survival, total_cash) 
                            VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sisss", $player_name, $total_kills, $quickest_time, $longest_survival, $total_cash);
    $stmt->execute();
}

$conn->close();
echo json_encode(["status" => "success", "message" => "Score updated"]);
?>
