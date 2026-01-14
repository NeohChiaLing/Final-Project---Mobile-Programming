<?php
// --- 把 db_connect.php 的内容直接贴在这里 ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fittrack";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
// -------------------------------------------

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$sql = "SELECT * FROM activities ORDER BY activity_date DESC";
$result = $conn->query($sql);

$activities = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $activities[] = $row;
    }
}
echo json_encode($activities);
$conn->close();
?>