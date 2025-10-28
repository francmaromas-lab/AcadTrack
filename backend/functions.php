<?php
// ==========================
// AcadTrack - FUNCTIONS.PHP
// Common reusable backend functions
// ==========================

include_once "config.php"; // para ma-connect sa database

// --------------------------
// LOGIN VALIDATION
// --------------------------
function loginUser($email, $password, $role)
{
    global $conn;

    $query = "SELECT * FROM users WHERE email = ? AND role = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['fullname'];
            $_SESSION['role'] = $user['role'];
            return true;
        }
    }
    return false;
}

// --------------------------
// REGISTER USER
// --------------------------
function registerUser($fullname, $email, $password, $role)
{
    global $conn;

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        return "Email already registered!";
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (fullname, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $fullname, $email, $hashed, $role);

    return $stmt->execute() ? "Registration successful!" : "Error registering user.";
}

// --------------------------
// FETCH ALL STUDENTS
// --------------------------
function getAllStudents()
{
    global $conn;
    $sql = "SELECT id, fullname, email, strand, section, year_level,    status FROM students ORDER BY fullname ASC";
    $result = $conn->query($sql);
    return $result;
}

// --------------------------
// DELETE STUDENT
// --------------------------
if (isset($_GET['action']) && $_GET['action'] == 'deleteStudent') {
    $id = $_GET['id'];
    if (deleteStudent($id)) {
        echo "Student deleted successfully!";
    } else {
        echo "Error deleting student.";
    }
}

function deleteStudent($id)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// --------------------------
// GENERATE REPORT
// --------------------------
function generateReport($type)
{
    global $conn;

    if ($type == "active") {
        $query = "SELECT * FROM students WHERE status='Active'";
    } elseif ($type == "inactive") {
        $query = "SELECT * FROM students WHERE status='Inactive'";
    } else {
        $query = "SELECT * FROM students";
    }

    return $conn->query($query);
}

// --------------------------
// LOGOUT FUNCTION
// --------------------------
function logoutUser()
{
    session_start();
    session_destroy();
    header("Location: ../login.html");
    exit();
}
?>
