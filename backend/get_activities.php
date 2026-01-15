<?php
// backend/get_activities.php

// 1. Enable Error Reporting (To debug hidden SQL errors)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'db_connect.php';

// 2. Select all activities
$sql = "SELECT * FROM activities ORDER BY activity_date DESC, id DESC";
$result = $conn->query($sql);

$activities = array();

// 3. Check for SQL Errors
if (!$result) {
    // If SQL fails, send the specific error message
    echo json_encode(["status" => "error", "message" => "SQL Error: " . $conn->error]);
    exit();
}

// 4. Build the list
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $activities[] = $row;
    }
}

// 5. Send the JSON in the CORRECT format
// Even if empty, we send status="success" so the App knows it worked.
echo json_encode(["status" => "success", "data" => $activities]);

$conn->close();
?>