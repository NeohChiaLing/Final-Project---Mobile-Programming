<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"));

if(isset($data->name)) {
    $name = $data->name;
    $height = $data->height;
    $weight = $data->weight;

    // Optional: Update image if sent
    $imageUpdate = "";
    if(isset($data->image) && !empty($data->image)) {
        $imageUpdate = ", image='" . $data->image . "'";
    }

    // Always update ID 1
    $sql = "UPDATE user_profile SET name='$name', height='$height', weight='$weight' $imageUpdate WHERE id=1";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Profile updated"]);
    } else {
        echo json_encode(["status" => "error", "message" => "DB Error: " . $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Input"]);
}
$conn->close();
?>
