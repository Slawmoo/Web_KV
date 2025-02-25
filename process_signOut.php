<?php
// Start the session to access and manage user data
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_data";

// Check if the user is logged in by verifying userId in session
if (isset($_SESSION['userId'])) {
    // Store user data from session for logging purposes
    $user_id = $_SESSION['userId'];
    $user_name = $_SESSION['user_name']; // Assumes user_name is stored in session during login

    // Establish a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check for connection errors and terminate if failed
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Log the user logout action in the admin_logs table
    $log_text = "User logged out: " . $user_name;
    $log_sql = "INSERT INTO admin_logs (user_id, text_of_changes, created_at) VALUES (?, ?, NOW())";
    if ($log_stmt = $conn->prepare($log_sql)) {
        // Bind parameters: i (integer) for user_id, s (string) for log text
        $log_stmt->bind_param("is", $user_id, $log_text);
        $log_stmt->execute();
        $log_stmt->close();
    }

    // Close the database connection
    $conn->close();
}

// Clear all session variables
session_unset();

// Destroy the session completely
session_destroy();

// Redirect the user to the home page with a "Guest" user parameter
header("Location: home.php?user=Guest");
exit();
?>