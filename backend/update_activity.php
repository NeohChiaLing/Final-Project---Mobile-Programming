<?php
// backend/update_activity.php

// 1. Setup Error Reporting & Headers
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
if(isset($data->id) && isset($data->date)) {
    $id = $data->id;
    $date = $data->date;
    $type = $data->type;
    $duration = $data->duration;
    $calories = $data->calories;
    $water = $data->water;
    $mood = $data->mood;
    $notes = $data->notes;

    // UPDATE SQL Query
    $sql = "UPDATE activities SET
            activity_date='$date',
            activity_type='$type',
            duration='$duration',
            calories='$calories',
            water_intake='$water',
            mood='$mood',
            notes='$notes'
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database Error: " . $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Missing ID or Date"]);
}

$conn->close();
?>