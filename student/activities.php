<?php
include_once "../backend/config.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access!";
    exit;
}

$student_id = $_SESSION['user_id'];

$query = "SELECT activity_title, activity_description, deadline, status 
          FROM activities WHERE student_id = ? ORDER BY deadline ASC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>
                <h3>{$row['activity_title']}</h3>
                <p>{$row['activity_description']}</p>
                <p><strong>Deadline:</strong> {$row['deadline']}</p>
                <p><strong>Status:</strong> {$row['status']}</p>
              </div><hr>";
    }
} else {
    echo "No activities found.";
}
?>
