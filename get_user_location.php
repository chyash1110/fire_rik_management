<?php
session_start();
include 'config.php';
header('Content-Type: application/json');

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT location, latitude, longitude FROM users WHERE id = '$user_id'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $location = $result->fetch_assoc();
        echo json_encode($location);
    } else {
        echo json_encode(['error' => 'Location not found']);
    }
} else {
    echo json_encode(['error' => 'User not logged in']);
}
?>
