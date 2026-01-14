<?php
// 1. 直接在这里写入数据库连接 (不再依赖外部文件，确保万无一失)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fittrack";

// 开启错误提示 (让你不再看到空白页，如果有错会直接显示)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// 2. 设置 API 头信息
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// 3. 处理写入逻辑
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 检查是否有数据发送过来
    if(isset($_POST['date']) && isset($_POST['type'])) {
        $date = $_POST['date'];
        $type = $_POST['type'];
        $duration = $_POST['duration'];
        $calories = $_POST['calories'];
        $water = $_POST['water'];
        $mood = $_POST['mood'];
        $notes = $_POST['notes'];

        // 准备 SQL
        $stmt = $conn->prepare("INSERT INTO activities (activity_date, activity_type, duration, calories, water_intake, mood, notes) VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        if($stmt) {
            $stmt->bind_param("ssiiiss", $date, $type, $duration, $calories, $water, $mood, $notes);
            
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Record saved successfully!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Execute Error: " . $stmt->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Prepare Error: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Missing required fields (date or type)"]);
    }
} else {
    // 如果直接用浏览器打开这个链接 (GET 请求)，提示用户
    echo json_encode(["status" => "info", "message" => "This is a POST API. Please use the test_tool.html to submit data."]);
}

$conn->close();
?>