<?php
include_once "../backend/config.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access!";
    exit;
}

$id = $_SESSION['user_id'];

$query = "SELECT fullname, email, strand, status FROM students WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($student = $result->fetch_assoc()) {
    echo "<p><strong>Name:</strong> {$student['fullname']}</p>";
    echo "<p><strong>Email:</strong> {$student['email']}</p>";
    echo "<p><strong>Strand:</strong> {$student['strand']}</p>";
    echo "<p><strong>Status:</strong> {$student['status']}</p>";
} else {
    echo "No information found.";
}
?>
