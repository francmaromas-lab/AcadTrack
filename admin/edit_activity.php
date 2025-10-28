<?php
// Connect to database
$conn = new mysqli("localhost", "root", "", "activity_db");

// Get ID from URL
$id = $_GET['id'] ?? 0;
$activity = null;

if ($id) {
    $res = $conn->query("SELECT * FROM activities WHERE id = $id");
    $activity = $res->fetch_assoc();
}

// Update when form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $desc = $conn->real_escape_string($_POST['description']);
    $date = $conn->real_escape_string($_POST['date']);
    $id = (int)$_POST['id'];

    $conn->query("UPDATE activities SET title='$title', description='$desc', date='$date' WHERE id=$id");
    echo "<script>alert('✅ Activity updated successfully!'); window.location='manage_activities.html';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Edit Activity | AcadTrack</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
body{background:#f4f6f9;display:flex;min-height:100vh;color:#333}
.sidebar{width:250px;background:#1e3a8a;color:#fff;padding:20px;display:flex;flex-direction:column;position:fixed;height:100%;box-shadow:2px 0 10px rgba(0,0,0,.15)}
.sidebar h2{text-align:center;margin-bottom:30px;font-size:22px}
.sidebar a{color:white;text-decoration:none;padding:12px 15px;border-radius:10px;transition:.3s;margin-bottom:10px;display:block}
.sidebar a:hover,.sidebar a.active{background:#2563eb}
.main{margin-left:270px;padding:40px;width:100%;animation:fadeIn .5s ease-in-out}
@keyframes fadeIn{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
form{background:white;padding:30px;border-radius:15px;box-shadow:0 4px 10px rgba(0,0,0,.1);max-width:500px;margin:auto}
h1{text-align:center;margin-bottom:20px}
label{display:block;margin-top:10px;font-weight:600}
input,textarea{width:100%;padding:10px;margin-top:5px;border:1px solid #ccc;border-radius:10px;transition:.3s}
input:focus,textarea:focus{border-color:#2563eb;outline:none;box-shadow:0 0 4px rgba(37,99,235,.4)}
button{margin-top:20px;background:#2563eb;color:white;border:none;padding:12px 20px;border-radius:10px;width:100%;cursor:pointer;font-weight:600;transition:.3s}
button:hover{background:#1d4ed8;transform:scale(1.03)}
</style>
</head>
<body>
  <div class="sidebar">
    <h2>AcadTrack Admin</h2>
    <a href="dashboard.html">Dashboard</a>
    <a href="calendar.html">Calendar</a>
    <a href="manage_activities.html" class="active">Activities</a>
    <a href="reports.html">Reports</a>
    <a href="students.html">Students</a>
    <a href="#">Logout</a>
  </div>

  <div class="main">
    <form method="POST">
      <h1>Edit Activity</h1>
      <input type="hidden" name="id" value="<?= htmlspecialchars($activity['id'] ?? '') ?>">
      
      <label>Title:</label>
      <input type="text" name="title" required value="<?= htmlspecialchars($activity['title'] ?? '') ?>">
      
      <label>Description:</label>
      <textarea name="description" rows="4" required><?= htmlspecialchars($activity['description'] ?? '') ?></textarea>
      
      <label>Date:</label>
      <input type="date" name="date" required value="<?= htmlspecialchars($activity['date'] ?? '') ?>">
      
      <button type="submit">💾 Update Activity</button>
    </form>
  </div>
</body>
</html>
