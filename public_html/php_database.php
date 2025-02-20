<?php

require_once "../../config.php";


$conn = new mysqli(DB_HOST, LDB_USER, LDB_PASS, LDB_NAME);
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the SQL statement from the form
    $sql = $_POST['sql_query'];

    // Check if it's an INSERT statement
    if (stripos(trim($sql), 'INSERT') === 0) {
        if ($conn->query($sql) === TRUE) {
            echo "Record inserted successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Only INSERT statements are allowed.";
    }
}

$conn->close();
?>
