<?php
include 'config.php';

$query = "SELECT id, location, status FROM fire_incidents WHERE status = 'active'";
$result = $conn->query($query);

$fireData = [];
while ($row = $result->fetch_assoc()) {
    $fireData[] = $row;
}

echo json_encode($fireData);
?>
