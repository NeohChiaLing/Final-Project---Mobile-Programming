<?php
// backend/create_activity.php

// 1. Enable Error Reporting (Helpful for debugging, same as your teammate's code)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Allow Access (CORS) & Set Content Type
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// 3. Include the Database Connection (Better practice than hardcoding credentials)
// Make sure you created db_connect.php in Step 2!
include 'db_connect.php';

// 4. Get JSON data sent from the Android App/JavaScript
// We use file_get_contents because the data is sent as raw JSON, not standard $_POST form data
$data = json_decode(file_get_contents("php://input"));

// 5. Check if data exists
if(isset($data->date) && isset($data->type)) {
    // Assign variables from the JSON object
    $date = $data->date;
    $type = $data->type;
    $duration = $data->duration;
    $calories = $data->calories;
    $water = $data->water;
    $mood = $data->mood;
    $notes = $data->notes;

    // 6. Prepare SQL statement (Prevents SQL Injection security issues)
    $stmt = $conn->prepare("INSERT INTO activities (activity_date, activity_type, duration, calories, water_intake, mood, notes) VALUES (?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        // "ssiiiss" means: String, String, Integer, Integer, Integer, String, String
        $stmt->bind_param("ssiiiss", $date, $type, $duration, $calories, $water, $mood, $notes);

        if($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Activity saved successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database Error: " . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "SQL Prepare Error: " . $conn->error]);
    }
} else {
    // If the data is empty or missing fields
    echo json_encode(["status" => "error", "message" => "Incomplete data. Received: " . file_get_contents("php://input")]);
}

$conn->close();
?>