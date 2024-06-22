<?php
session_start();
include 'config.php';

$error="";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $location = $_POST['location'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $contact_number = $_POST['contact_number'];

    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $role = mysqli_real_escape_string($conn, $role);
    $location = mysqli_real_escape_string($conn, $location);
    $latitude = mysqli_real_escape_string($conn, $latitude);
    $longitude = mysqli_real_escape_string($conn, $longitude);
    $contact_number = mysqli_real_escape_string($conn, $contact_number);

    if (!preg_match("/^[A-Za-z]+$/", $username)) {
        $error = "Name should only contain English alphabets.";
    }

    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/", $password)) {
        $error = "Password must be at least 6 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
    }

    $email_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = $conn->query($email_check_query);

    if ($result->num_rows > 0) {
        $error = "Email is already registered.";
    }

    if (!preg_match("/^\d{10}$/", $contact_number)) {
        $error = "Contact number must be exactly 10 digits.";
    }

    if (!isset($error)) {
        $query = "INSERT INTO users (username, password, email, role, location, latitude, longitude, contact) VALUES ('$username', '$password', '$email', '$role', '$location', '$latitude', '$longitude', '$contact_number')";
        if ($conn->query($query) === TRUE) {
            header('Location: login.php');
            exit;
        } else {
            $error = "Error: " . $query . "<br>" . $conn->error;
        }
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
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
            <label for="username">Name:</label>
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
        </form>
    </div>

    <script src="js/register.js"></script>
    <script>
        <?php if (!empty($error)) { ?>
            alert('<?php echo $error; ?>');
        <?php } ?>
    </script>
</body>
</html>
