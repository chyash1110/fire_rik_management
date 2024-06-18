<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fire_management";
$weather_api_key = "643c0faf080d2508eb001ebc61d7f31c";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
