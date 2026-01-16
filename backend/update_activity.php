<?php
// backend/update_activity.php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"));

if(isset($data->id)) {
    $id = $data->id;
    $date = $data->date;
    $type = $data->type; // Correct
    $duration = $data->duration;
    $calories = $data->calories;
    $water = $data->water;
    $mood = $data->mood;
    $notes = $data->notes;
    $image = isset($data->image) ? $data->image : ""; // Handle image

    // If image is empty string, we might want to keep the old one?
    // For now, this updates it to whatever is sent.
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