<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

$user = $_SESSION['username']; // Get the logged-in username
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($user); ?>!</h2>
    <p>You have successfully logged in.</p>
    <p><a href="login.php">Logout</a></p>
</body>
</html>
