<?php
include_once "../backend/config.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access!";
    exit;
}

$student_id = $_SESSION['user_id'];

$query = "SELECT title, event_date, description FROM calendar WHERE student_id = ? ORDER BY event_date ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($event = $result->fetch_assoc()) {
        echo "<div>
                <h3>{$event['title']}</h3>
                <p><strong>Date:</strong> {$event['event_date']}</p>
                <p>{$event['description']}</p>
              </div><hr>";
    }
} else {
    echo "No upcoming events.";
}
?>
