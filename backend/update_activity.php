<?php
// backend/update_activity.php

// 1. Setup Error Reporting & Headers (SAME AS OLD)
ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'db_connect.php';

// 2. Get Data
$data = json_decode(file_get_contents("php://input"));

// 3. Update Logic
if(isset($data->id)) {
    $id = $data->id;
    $date = $data->date;
    $type = $data->type;
    $duration = $data->duration;
    $calories = $data->calories;
    $water = $data->water;
    $mood = $data->mood;
    $notes = $data->notes;

    // NEW: Get the Image (If it's empty, we save an empty string, logic handled by Frontend)
    $image = isset($data->image) ? $data->image : "";

    // UPDATE SQL Query (Added 'image' column)
    $sql = "UPDATE activities SET
            activity_date='$date',
            activity_type='$type',
            duration='$duration',
            calories='$calories',
            water_intake='$water',
            mood='$mood',
            notes='$notes',
            image='$image'
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database Error: " . $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Missing ID"]);
}

$conn->close();
?>