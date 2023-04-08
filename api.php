<?php
// Set up headers to allow cross-domain requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

// Connect to MySQL server
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "example_db";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for errors in connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle GET request to retrieve data
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $result = $conn->query("SELECT * FROM example_table");
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    echo json_encode($rows);
}

// Handle POST request to insert data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $name = $data['name'];
    $age = $data['age'];
    $stmt = $conn->prepare("INSERT INTO example_table (name, age) VALUES (?, ?)");
    $stmt->bind_param("si", $name, $age);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
?>
