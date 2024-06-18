<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'transport') {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = '$user_id'";
$user = $conn->query($query)->fetch_assoc();

$bookings_query = "
    SELECT b.*, u.username AS booked_by_username, t.service_name 
    FROM bookings b 
    JOIN users u ON b.user_id = u.id 
    JOIN transportation_services t ON b.transportation_id = t.id 
    WHERE b.transportation_id IN (
        SELECT id FROM transportation_services WHERE provider_id = '$user_id'
    )";
$bookings = $conn->query($bookings_query);

$services_query = "SELECT * FROM transportation_services WHERE provider_id = '$user_id'";
$services = $conn->query($services_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Transportation</title>
    <link rel="stylesheet" type="text/css" href="css/user.css">
</head>
<body>
    <header>
        Fire Risk Management System
        <nav>
            <a href="dashboard_transport.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <h1>Welcome, <?php echo $user['username']; ?></h1>
    <p>Location: <span id="user-location">Fetching...</span></p>
    <p>Weather: <span id="weather">Fetching...</span></p>

    <h2>Your Bookings</h2>
    <ul>
        <?php if ($bookings->num_rows > 0) {
            while ($booking = $bookings->fetch_assoc()) { ?>
                <li>
                    <?php echo $booking['timestamp']; ?> - From: <?php echo $booking['source']; ?> To: <?php echo $booking['destination']; ?> 
                    (Service: <?php echo $booking['service_name']; ?>, Booked by: <?php echo $booking['booked_by_username']; ?>)
                </li>
            <?php }
        } else { ?>
            <li>No records found</li>
        <?php } ?>
    </ul>


    <h2>Your Transportation Services</h2>
    <ul>
        <?php if ($services->num_rows > 0) {
            while ($service = $services->fetch_assoc()) { ?>
                <li><?php echo $service['service_name']; ?> - <?php echo $service['details']; ?></li>
            <?php }
        } else { ?>
            <li>No records found</li>
        <?php } ?>
    </ul>

    <h2>Add Transportation Service</h2>
    <form method="post" action="add_transport_service.php">
        <label for="service_name">Service Name:</label>
        <input type="text" id="service_name" name="service_name" required><br>
        <label for="details">Fare Details:</label>
        <textarea id="details" name="details" required></textarea><br>
        <button type="submit">Add Service</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/forest_transport.js"></script>
</body>
</html>
