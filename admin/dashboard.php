<?php
include 'includes/header.php';
include 'includes/sidebar.php';
include 'includes/db_connect.php';

$totalStudents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM students"))['total'];
$totalActivities = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM activities"))['total'];
$totalReports = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM reports"))['total'];
?>

<div class="main-content">
  <?php include 'includes/header.php'; ?>

  <div class="cards">
    <div class="card card-students">
      <h3>Total Students</h3>
      <p><?= $totalStudents ?> students enrolled</p>
    </div>
    <div class="card card-activities">
      <h3>Activities</h3>
      <p><?= $totalActivities ?> ongoing activities</p>
    </div>
    <div class="card card-reports">
      <h3>Reports</h3>
      <p><?= $totalReports ?> reports generated</p>
    </div>
  </div>

  <div class="quick-actions">
    <button class="btn btn-add">Add New Activity</button>
    <button class="btn btn-view">View Reports</button>
  </div>
</div>
<script>
  document.querySelectorAll('.card p').forEach(card => {
    let value = parseInt(card.innerText) || 0;
    let count = 0;
    let speed = 20; 
    const increment = Math.ceil(value / speed);

    const counter = setInterval(() => {
      count += increment;
      if(count >= value) {
        card.innerText = value + card.innerText.replace(/\d+/g, '');
        clearInterval(counter);
      } else {
        card.innerText = count + card.innerText.replace(/\d+/g, '');
      }
    }, 30);
  });
</script>

<?php include 'includes/footer.php'; ?>
