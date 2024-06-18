<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'forest') {
    header('Location: login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $location = $_POST['location'];
    $start_date = $_POST['start_date'];
    $exhaust_date = $_POST['exhaust_date'];
    $area_burnt = $_POST['area_burnt'];

    $query = "INSERT INTO historical_fires (location, start_date, exhaust_date, area_burnt) VALUES ('$location', '$start_date', '$exhaust_date', '$area_burnt')";
    if ($conn->query($query) === TRUE) {
        header('Location: dashboard_forest.php');
        exit;
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}
?>