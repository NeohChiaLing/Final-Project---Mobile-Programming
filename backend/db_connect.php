<?php
// backend/db_connect.php
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP password is empty
$dbname = "fittrack";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>