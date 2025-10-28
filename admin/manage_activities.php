<?php
$conn = new mysqli("localhost", "root", "", "activity_db");
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

// Delete
if(isset($_POST['delete'])){
    $id = $_POST['delete'];
    $stmt = $conn->prepare("DELETE FROM activities WHERE id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();
    exit;
}

// Add / Edit
if(isset($_POST['name'], $_POST['desc'], $_POST['date'])){
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $date = $_POST['date'];

    if($id == ''){
        $stmt = $conn->prepare("INSERT INTO activities(activity_name, description, date) VALUES(?,?,?)");
        $stmt->bind_param("sss",$name,$desc,$date);
    } else {
        $stmt = $conn->prepare("UPDATE activities SET activity_name=?, description=?, date=? WHERE id=?");
        $stmt->bind_param("sssi",$name,$desc,$date,$id);
    }
    $stmt->execute();
    $stmt->close();
    exit;
}

// Display / Search
$search = $_GET['search'] ?? '';
$search_like = "%$search%";
$stmt = $conn->prepare("SELECT * FROM activities WHERE activity_name LIKE ? OR description LIKE ? ORDER BY id DESC");
$stmt->bind_param("ss",$search_like,$search_like);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows>0){
    while($row=$result->fetch_assoc()){
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['activity_name']}</td>
            <td>{$row['description']}</td>
            <td>{$row['date']}</td>
            <td>
                <button class='edit-btn' onclick=\"editActivity('{$row['id']}', '".addslashes($row['activity_name'])."', '".addslashes($row['description'])."', '{$row['date']}')\">Edit</button>
                <button class='delete-btn' onclick=\"deleteActivity('{$row['id']}')\">Delete</button>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='5' style='text-align:center;color:gray;'>No activities found</td></tr>";
}
$stmt->close();
$conn->close();
?>
