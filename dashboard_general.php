<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'general') {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = '$user_id'";
$user = $conn->query($query)->fetch_assoc();

$incidents_query = "SELECT * FROM fire_incidents WHERE status = 'active'";
$incidents = $conn->query($incidents_query);

$bookings_query = "SELECT b.*, t.service_name, u.username AS provider_name FROM bookings b 
                   JOIN transportation_services t ON b.transportation_id = t.id
                   JOIN users u ON t.provider_id = u.id
                   WHERE b.user_id = '$user_id'";
$bookings = $conn->query($bookings_query);

$book_query= "SELECT * FROM transportation_services";
$services = $conn->query($book_query);

$historical_query = "SELECT * FROM historical_fires";
$historical_fires = $conn->query($historical_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - General Public</title>
    <link rel="stylesheet" type="text/css" href="css/user.css">
</head>
<body>
<header>
        Fire Risk Management System
        <nav>
            <a href="dashboard_general.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <h1>Welcome, <?php echo $user['username']; ?></h1>
    <p>Your location: <span id="user-location">Fetching...</span></p>
    <p>Weather: <span id="weather">Fetching...</span></p>

    <h2>Active Fire Incidents</h2>
    <ul>
    <?php if ($incidents->num_rows > 0) {
        while ($incident = $incidents->fetch_assoc()) { ?>
            <li><?php echo $incident['location']; ?> -- Time to reach: <span class="spread-time" data-incident-id="<?php echo $incident['id']; ?>">Calculating...</span></li>
        <?php }
    } else { ?>
        <li>No records found</li>
    <?php } ?>
    </ul>

    <h2>Transportation Bookings</h2>
    <ul>
        <?php if ($bookings->num_rows > 0) {
            while ($booking = $bookings->fetch_assoc()) { ?>
                <li><?php echo $booking['timestamp']; ?> - From: <?php echo $booking['source']; ?> To: <?php echo $booking['destination']; ?> (Service: <?php echo $booking['service_name']; ?>, Provider: <?php echo $booking['provider_name']; ?>)</li>
            <?php }
        } else { ?>
            <li>No records found</li>
        <?php } ?>
    </ul>

    <h2>Book Transportation</h2>
    <form method="post" action="book_transport.php">
        <label for="transportation_id">Select Service:</label>
        <select name="transportation_id" id="transportation_id">
            <?php if ($services->num_rows > 0) {
                while ($service = $services->fetch_assoc()) { ?>
                    <option value="<?php echo $service['id']; ?>"><?php echo $service['service_name']; ?></option>
                <?php }
            } else { ?>
                <option value="">No services available</option>
            <?php } ?>
        </select>

        <div id="service-details">
        
    </div>

        <label for="source">Source:</label>
        <input type="text" id="source" name="source" required>

        <label for="destination">Destination:</label>
        <input type="text" id="destination" name="destination" required><br>

        <button type="submit">Book</button>
    </form>

    <h2>Historical Fire Data</h2>
    <ul>
        <?php while ($fire = $historical_fires->fetch_assoc()) { ?>
            <li><?php echo $fire['location']; ?> - Start Date: <?php echo $fire['start_date']; ?>, Exhaust Date: <?php echo $fire['exhaust_date']; ?>, Area Burnt: <?php echo $fire['area_burnt']; ?> hectares</li>
        <?php } ?>
    </ul>

    <h2>Contact Forest Users</h2>
    <ul>
        <?php
        $forest_users_query = "SELECT username, location, contact FROM users WHERE role = 'forest'";
        $forest_users_result = $conn->query($forest_users_query);
        if ($forest_users_result->num_rows > 0) {
            while ($forest_user = $forest_users_result->fetch_assoc()) {
                echo "<li>Name: " . $forest_user['username'] . ", Location: " . $forest_user['location'] . ", Contact: " . $forest_user['contact'] . "</li>";
            }
        } else {
            echo "<li>No forest users found</li>";
        }
        ?>
    </ul>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src='js/general.js'></script>
</body>
</html>
