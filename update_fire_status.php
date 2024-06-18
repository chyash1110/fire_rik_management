<?php
include 'config.php';

$incident_id = $_POST['incident_id'];
$status = $_POST['status'];
$timestamp_column = '';

if ($status == 'contained') {
    $timestamp_column = 'contained_at';
} elseif ($status == 'extinguished') {
    $timestamp_column = 'extinguished_at';
}

if ($timestamp_column) {
    $query = "UPDATE fire_incidents SET status = '$status', $timestamp_column = CURRENT_TIMESTAMP WHERE id = '$incident_id'";
} else {
    $query = "UPDATE fire_incidents SET status = '$status' WHERE id = '$incident_id'";
}

$conn->query($query);

header('Location: dashboard_forest.php');
?>
