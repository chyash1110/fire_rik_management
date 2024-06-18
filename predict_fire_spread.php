<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $incident_id = $_POST['incident_id'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    $incident_query = "SELECT * FROM fire_incidents WHERE id = '$incident_id'";
    $incident = $conn->query($incident_query)->fetch_assoc();

    if ($incident) {
        $location = $incident['location'];
        $temperature = $incident['temperature'];
        $humidity = $incident['humidity'];
        $wind_speed = $incident['wind_speed'];
        $distance = calculateDistance($latitude, $longitude, $incident['latitude'], $incident['longitude']);
        $terrain_type = $incident['terrain_type'];
        $vegetation_type = $incident['vegetation_type'];

        $data = array(
            'temperature' => $temperature,
            'humidity' => $humidity,
            'wind_speed' => $wind_speed,
            'distance' => $distance,
            'terrain_type' => $terrain_type,
            'vegetation_type' => $vegetation_type
        );

        $url = 'http://127.0.0.1:5000/predict'; 
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json",
                'method'  => 'POST',
                'content' => json_encode($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
            // Handle error
            echo json_encode(['error' => 'Failed to fetch prediction']);
        } else {
            // Decode JSON response
            $response = json_decode($result, true);
            if (isset($response['spread_time'])) {
                echo json_encode(['spread_time' => $response['spread_time']]);
            } else {
                echo json_encode(['error' => 'Unable to calculate']);
            }
        }
    } else {
        echo json_encode(['error' => 'Incident not found']);
    }
}

function calculateDistance($lat1, $lon1, $lat2, $lon2) {
    $earth_radius = 6371; 
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $distance = $earth_radius * $c;
    return $distance;
}
