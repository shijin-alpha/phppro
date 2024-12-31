<?php
// Database connection parameters
$servername = "localhost"; // Usually localhost
$username = "root"; // Database username
$password = ""; // Database password (leave empty if no password is set for MySQL)
$dbname = "login_system"; // Database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$login_error = ""; // For storing login error messages

// Handle Login
if (isset($_POST['login'])) {
    // Get user input from the login form
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Prevent SQL injection
    $user = $conn->real_escape_string($user);
    $pass = $conn->real_escape_string($pass);

    // Query to get the user from the database
    $sql = "SELECT * FROM users WHERE username = '$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($pass, $row['password'])) {
            // Successful login, start session and redirect to the welcome page
            session_start();
            $_SESSION['username'] = $user;
            header("Location: welcome.php");
            exit;
        } else {
            // Password mismatch
            $login_error = "Invalid username or password.";
        }
    } else {
        // Username doesn't exist
        $login_error = "Invalid username or password.";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
    <h2>Login</h2>

    <!-- Display error message if login fails -->
    <?php if (!empty($login_error)): ?>
        <p style="color: red;"><?php echo $login_error; ?></p>
    <?php endif; ?>

    <!-- Login Form -->
    <form action="" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit" name="login">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>
