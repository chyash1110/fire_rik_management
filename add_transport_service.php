<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'transport') {
    header('Location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];
$service_name = $_POST['service_name'];
$details = $_POST['details'];
$query = "INSERT INTO transportation_services (provider_id, service_name, details) VALUES ('$user_id', '$service_name', '$details')";
if ($conn->query($query) === TRUE) {
    header('Location: dashboard_transport.php');
        exit;
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}
?>
