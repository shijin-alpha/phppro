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

$registration_error = ""; // For storing registration error messages
$registration_success = ""; // For storing registration success messages

// Handle Registration
if (isset($_POST['register'])) {
    // Get user input from the form
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Prevent SQL injection
    $user = $conn->real_escape_string($user);
    $pass = $conn->real_escape_string($pass);

    // Hash the password (use bcrypt for better security)
    $pass_hashed = password_hash($pass, PASSWORD_BCRYPT);

    // Check if the username already exists
    $check_sql = "SELECT * FROM users WHERE username = '$user'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        // Username already exists
        $registration_error = "Username already exists. Please choose a different one.";
    } else {
        // Insert the new user into the database
        $insert_sql = "INSERT INTO users (username, password) VALUES ('$user', '$pass_hashed')";

        if ($conn->query($insert_sql) === TRUE) {
            $registration_success = "Registration successful! You can now log in.";
        } else {
            $registration_error = "Error: " . $conn->error;
        }
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
    <title>Register Page</title>
</head>
<body>
    <h2>Register</h2>

    <!-- Display success or error message -->
    <?php if (!empty($registration_success)): ?>
        <p style="color: green;"><?php echo $registration_success; ?></p>
    <?php elseif (!empty($registration_error)): ?>
        <p style="color: red;"><?php echo $registration_error; ?></p>
    <?php endif; ?>

    <!-- Registration Form -->
    <form action="" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit" name="register">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
