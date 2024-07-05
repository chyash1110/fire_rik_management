<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'general') {
            header('Location: dashboard_general.php');
        } elseif ($user['role'] == 'transport') {
            header('Location: dashboard_transport.php');
        } elseif ($user['role'] == 'forest') {
            header('Location: dashboard_forest.php');
        }
        exit;
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
        <h1>Login</h1>
        <form method="post">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
            <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
        </form>
    </div>
</body>
</html>
