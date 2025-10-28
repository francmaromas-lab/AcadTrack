<?php
$conn = new mysqli("localhost", "root", "", "activity_db");

if(isset($_POST['name'])){
  $name=$conn->real_escape_string($_POST['name']);
  $conn->query("INSERT INTO students (student_name) VALUES('$name')");
  exit;
}

$search=$conn->real_escape_string($_GET['search']??'');
$res=$conn->query("SELECT * FROM students WHERE student_name LIKE '%$search%' ORDER BY id DESC");
if($res->num_rows>0){
  while($r=$res->fetch_assoc()){
    echo "<tr><td>{$r['id']}</td><td>{$r['student_name']}</td></tr>";
  }
}else{
  echo "<tr><td colspan='2'>No students found</td></tr>";
}
$conn->close();
?>
