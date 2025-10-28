<?php
session_start();
include("config.php");

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $row['id'];
        $_SESSION['fullname'] = $row['fullname'];
        $_SESSION['role'] = $row['role'];

        if ($row['role'] == 'admin') {
            header("Location: ../admin/dashboard.html");
        } else {
            header("Location: ../student/dashboard.html");
        }
        exit();
    } else {
        echo "<script>alert('Invalid Email or Password'); window.history.back();</script>";
    }
}
?>
