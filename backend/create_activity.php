<?php
// backend/create_activity.php

// 1. CORS Headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"));

// FIXED: Changed 'activity_type' to 'type' to match your HTML
if(isset($data->type) && isset($data->duration)) {

    $date = $data->date;
    $type = $data->type; // Matches HTML now
    $duration = $data->duration;
    $calories = $data->calories;
    $water = $data->water;
    $mood = $data->mood;
    $notes = $data->notes;
    // Handle Image (Check if exists, otherwise empty)
    $image = isset($data->image) ? $data->image : "";

    // Added 'image' to insert query
    $sql = "INSERT INTO activities (activity_date, activity_type, duration, calories, water_intake, mood, notes, image)
            VALUES ('$date', '$type', '$duration', '$calories', '$water', '$mood', '$notes', '$image')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Activity created successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "DB Error: " . $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Input: Missing Type or Duration"]);
}

$conn->close();
?>