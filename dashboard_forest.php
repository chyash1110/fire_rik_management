<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'forest') {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = '$user_id'";
$user = $conn->query($query)->fetch_assoc();

$incidents_query = "SELECT * FROM fire_incidents";
$incidents = $conn->query($incidents_query);

$historical_query = "SELECT * FROM historical_fires";
$historical_fires = $conn->query($historical_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Forest Department</title>
    <link rel="stylesheet" type="text/css" href="css/user.css">
</head>
<body>
<header>
        Fire Risk Management System
        <nav>
            <a href="dashboard_forest.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <h1>Welcome, <?php echo $user['username']; ?></h1>
    <p>Your location: <span id="user-location">Fetching...</span></p>
    <p>Weather: <span id="weather">Fetching...</span></p>

    <h2>Report Fire Incidents</h2>
    <form method="post" action="add_fire_incident.php">
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required>
        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="active">Active</option>
            <option value="contained">Contained</option>
            <option value="extinguished">Extinguished</option>
        </select><br>
        <button type="submit">Add Fire Incident</button>
    </form>

    <h2>Update Fire Incident Status</h2>
    <form method="post" action="update_fire_status.php">
        <label for="incident_id">Incident ID:</label>
        <select id="incident_id" name="incident_id" required>
            <?php while ($incident = $incidents->fetch_assoc()) { ?>
                <option value="<?php echo $incident['id']; ?>"><?php echo $incident['location']; ?> - <?php echo $incident['status']; ?></option>
            <?php } ?>
        </select>
        <label for="status">Status:</label>
        <select id="update_status" name="status">
            <option value="active">Active</option>
            <option value="contained">Contained</option>
            <option value="extinguished">Extinguished</option>
        </select><br>
        <button type="submit">Update Status</button>
    </form>

    <h2>Current Fire Incidents</h2>
    <ul>
        <?php
        if ($incidents->num_rows > 0) {
            $incidents->data_seek(0); 
            while ($incident = $incidents->fetch_assoc()) {
                echo '<li>' . $incident['location'] . ' - ' . $incident['status'] . '<br>';
                echo 'Reported Active: ' . $incident['created_at'] . '<br>';
                echo 'Reported Contained: ' . ($incident['contained_at'] ?: 'N/A') . '<br>';
                echo 'Reported Extinguished: ' . ($incident['extinguished_at'] ?: 'N/A') . '</li>';
            }
        } else {
            echo '<li>No fire incidents found</li>';
        }
        ?>
    </ul>

    <h2>Add Historical Fire Data</h2>
    <form method="post" action="add_historical_fire.php">
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required>
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>
        <label for="exhaust_date">Exhaust Date:</label>
        <input type="date" id="exhaust_date" name="exhaust_date" required>
        <label for="area_burnt">Area Burnt (hectares):</label>
        <input type="number" id="area_burnt" name="area_burnt" required><br><br>
        <button type="submit">Add Historical Fire Data</button>
    </form>

    <h2>Historical Fire Data</h2>
    <ul>
        <?php while ($fire = $historical_fires->fetch_assoc()) { ?>
            <li><?php echo $fire['location']; ?> - Start Date: <?php echo $fire['start_date']; ?>, Exhaust Date: <?php echo $fire['exhaust_date']; ?>, Area Burnt: <?php echo $fire['area_burnt']; ?> hectares</li>
        <?php } ?>
    </ul>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/forest_transport.js"></script>
</body>
</html>
