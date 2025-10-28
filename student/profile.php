<?php
include_once "../backend/config.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access!";
    exit;
}

$id = $_SESSION['user_id'];
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$strand = $_POST['strand'];
$password = $_POST['password'];

if (!empty($password)) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $query = "UPDATE students SET fullname=?, email=?, strand=?, password=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $fullname, $email, $strand, $hashed, $id);
} else {
    $query = "UPDATE students SET fullname=?, email=?, strand=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $fullname, $email, $strand, $id);
}

if ($stmt->execute()) {
    echo "Profile updated successfully!";
} else {
    echo "Error updating profile.";
}
?>
