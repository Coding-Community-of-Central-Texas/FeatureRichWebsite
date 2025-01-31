<?php
// Database credentials
$host = "localhost:3306"; // Usually 'localhost'
$dbname = "osccctor_Member"; // Replace with your database name
$username = "osccctor_new_member"; // Replace with your database username
$password = "newmember69!"; // Replace with your database password

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
