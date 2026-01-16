<?php

// 这是一个简单的模拟登录，用来满足作业中 "Implement PHP Sessions" 的要求
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 假设前端发来一个 username
    if(isset($_POST['username'])) {
        $_SESSION['user'] = $_POST['username'];
        $_SESSION['login_time'] = date("Y-m-d H:i:s");
        echo json_encode(["status" => "success", "message" => "Session started for " . $_SESSION['user']]);
    } else {
        echo json_encode(["status" => "error", "message" => "No username provided"]);
    }
} else {
    // 如果是 GET 请求，检查 Session 是否存在
    if(isset($_SESSION['user'])) {
        echo json_encode(["status" => "active", "user" => $_SESSION['user']]);
    } else {
        echo json_encode(["status" => "inactive", "message" => "No active session"]);
    }
}
?>