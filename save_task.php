<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "todo_list_db";

// Create a connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error;
}

// Select the database
$conn->select_db($database);

// Create the tasks table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS tasks (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    task_text VARCHAR(255) NOT NULL,
    time_planned datetime(6)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error;
}

// Check if a task is submitted
if (isset($_POST['task'])) {
    $task = $_POST['task'];
    $timePlanned = $_POST['time_planned'];

// Insert the task into the tasks table
$stmt = $conn->prepare("INSERT INTO tasks (task_text, time_planned) VALUES (?, ?)");
if ($stmt === false) {
    die("Error: " . $conn->error);
}

$stmt->bind_param("ss", $task, $timePlanned);
if ($stmt === false) {
    die("Error: " . $stmt->error);
}

$stmt->execute();
if ($stmt === false) {
    die("Error: " . $stmt->error);
}

    $stmt->close();
}

// Close the connection
$conn->close();
?>
