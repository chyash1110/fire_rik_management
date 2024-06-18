<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $location = $_POST['location'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $contact_number = $_POST['contact_number'];
    $contact_number = mysqli_real_escape_string($conn, $contact_number);
    $query = "INSERT INTO users (username, password, role, location, latitude, longitude, contact) VALUES ('$username', '$password', '$role', '$location', '$latitude', '$longitude', '$contact_number')";
    if ($conn->query($query) === TRUE) {
        header('Location: login.php');
        exit;
    } else {
        $error = "Error: " . $query . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/login_reg.css">
</head>
<body>
    <header>
        Fire Risk Management System
        <nav>
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        </nav>
    </header>
    <div class='form-container'>
        <h1>Register</h1>
        <form method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="role">Role:</label>
            <select id="role" name="role">
                <option value="general">General Public</option>
                <option value="transport">Transportation</option>
                <option value="forest">Forest Department</option>
            </select>
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required readonly>
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">
            <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" required>
            <button type="submit">Register</button>
            <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
        </form>
    </div>

    <script src="js/register.js"></script>
    <script>
        getLocation();
    </script>
</body>
</html>
