<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fittrack";

// 开启错误提示
ini_set('display_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli($servername, $username, $password, $dbname);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 修改需要知道是哪一条记录 (id)
    if(isset($_POST['id']) && isset($_POST['date'])) {
        $id = $_POST['id'];
        $date = $_POST['date'];
        $type = $_POST['type'];
        $duration = $_POST['duration'];
        $calories = $_POST['calories'];
        $water = $_POST['water'];
        $mood = $_POST['mood'];
        $notes = $_POST['notes'];

        $stmt = $conn->prepare("UPDATE activities SET activity_date=?, activity_type=?, duration=?, calories=?, water_intake=?, mood=?, notes=? WHERE id=?");
        $stmt->bind_param("ssiiissi", $date, $type, $duration, $calories, $water, $mood, $notes, $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Record updated successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Update failed: " . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Missing ID or Data"]);
    }
}
$conn->close();
?>