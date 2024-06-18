<?php
include 'config.php';

function get_weather_data($location) {
    $api_key = '643c0faf080d2508eb001ebc61d7f31c';
    $weather_api_url = "http://api.openweathermap.org/data/2.5/weather?q=$location&appid=$api_key";
    $weather_data = file_get_contents($weather_api_url);
    return json_decode($weather_data, true);
}

    function get_geolocation($location) {
        $api_key = 'AIzaSyALB6uQiBGnyZAJMiS1MAT8ViJmRQea8W0';
        $encoded_location = urlencode($location); 
        $geo_api_url = "https://maps.googleapis.com/maps/api/geocode/json?address=$encoded_location&key=$api_key";
    
        $geo_data = file_get_contents($geo_api_url);
        if ($geo_data === false) {
            return null; 
        }
        return json_decode($geo_data, true);
    }
    
    function get_elevation($latitude, $longitude) {
        $api_key = 'AIzaSyALB6uQiBGnyZAJMiS1MAT8ViJmRQea8W0';
        $elevation_api_url = "https://maps.googleapis.com/maps/api/elevation/json?locations=$latitude,$longitude&key=$api_key";
    
        $elevation_data = file_get_contents($elevation_api_url);
        if ($elevation_data === false) {
            return null; 
        }
        return json_decode($elevation_data, true);
    }

function determine_terrain_type($elevation) {
    if ($elevation > 500) {
        return "mountainous";
    } else if ($elevation > 100) {
        return "hilly";
    } else {
        return "flat";
    }
}

function get_vegetation_type($latitude, $longitude) {
    $json_data = file_get_contents('data/vegetation.json');
    $coordinates = json_decode($json_data, true);

    foreach ($coordinates as $coord) {
        if ($latitude >= $coord['latitude'][0] && $latitude <= $coord['latitude'][1] &&
            $longitude >= $coord['longitude'][0] && $longitude <= $coord['longitude'][1]) {
            return $coord['vegetation'];
        }
    }
    return "forest";
}

$location = $_POST['location'];
$status = $_POST['status'];

$weather = get_weather_data($location);
$temperature_kelvin = $weather['main']['temp'] ?? null;
$temperature= $temperature_kelvin - 273.15;
$humidity = $weather['main']['humidity'];
$wind_speed = $weather['wind']['speed'];

$geo = get_geolocation($location);
$latitude = $geo['results'][0]['geometry']['location']['lat'];
$longitude = $geo['results'][0]['geometry']['location']['lng'];

$elevation_data = get_elevation($latitude, $longitude);
$elevation = $elevation_data['results'][0]['elevation'];
$terrain_type = determine_terrain_type($elevation);

$vegetation_type = get_vegetation_type($latitude, $longitude);

$query = "INSERT INTO fire_incidents (location, status, temperature, humidity, wind_speed, latitude, longitude, terrain_type, vegetation_type) VALUES ('$location', '$status', $temperature, $humidity, $wind_speed, $latitude, $longitude, '$terrain_type', '$vegetation_type')";
$conn->query($query);

header('Location: dashboard_forest.php');
?>
