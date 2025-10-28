<?php
$conn = new mysqli("localhost", "root", "", "activity_db");
$search = $conn->real_escape_string($_GET['search'] ?? '');
$res = $conn->query("SELECT * FROM reports WHERE report_title LIKE '%$search%'");
if($res->num_rows>0){
  while($r=$res->fetch_assoc()){
    echo "<tr><td>{$r['id']}</td><td>{$r['report_title']}</td><td>{$r['description']}</td></tr>";
  }
}else{
  echo "<tr><td colspan='3'>No reports found</td></tr>";
}
$conn->close();
?>
