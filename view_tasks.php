<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "todo_list_db";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select all tasks from the tasks table
$sql = "SELECT * FROM tasks";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        $taskText = $row["task_text"];
        $timePlanned = $row["time_planned"];
        $taskDue = false;

        // Check if the task is due or has passed
        if ($timePlanned !== null) {
            $currentDateTime = new DateTime();
            $taskDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $timePlanned);
            if ($taskDateTime <= $currentDateTime) {
                $taskDue = true;
            }
        }

        if ($taskDue) {
            echo "<li class='task-due' onmouseover='playBeep()'>" . $taskText . "</li>";
        } else {
            echo "<li>" . $taskText . "</li>";
        }
    }
    echo "</ul>";
} else {
    echo "No tasks found";
}

// Close the connection
$conn->close();
?>
<script src="script.js"></script>
