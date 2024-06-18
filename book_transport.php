<?php
session_start();
include 'config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $transportation_id = $_POST['transportation_id'];
    $source = $_POST['source'];
    $destination = $_POST['destination'];
    $query = "INSERT INTO bookings (user_id, transportation_id, source, destination) VALUES ('$user_id', '$transportation_id', '$source', '$destination')";
    if ($conn->query($query) === TRUE) {
        header('Location: dashboard_general.php');
        exit;
    } else {
        $error = "Error: " . $query . "<br>" . $conn->error;
    }
}
?>
