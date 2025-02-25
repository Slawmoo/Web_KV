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
    // Store user data from session for use in the script
    $user_id = $_SESSION['userId'];
    $user_name = $_SESSION['user_name'];
    $user_email = $_SESSION['userEmail'];

    // Establish a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check for connection errors and terminate if failed
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Log the account deletion in the admin_logs table
    $log_text = "User deleted account: " . $user_name;
    $log_sql = "INSERT INTO admin_logs (user_id, text_of_changes, created_at) VALUES (?, ?, NOW())";
    if ($log_stmt = $conn->prepare($log_sql)) {
        // Bind parameters: i (integer) for user_id, s (string) for log text
        $log_stmt->bind_param("is", $user_id, $log_text);
        $log_stmt->execute();
        $log_stmt->close();
    }

    // Prepare SQL query to delete the user from the users table
    $delete_sql = "DELETE FROM users WHERE id = ?";
    if ($delete_stmt = $conn->prepare($delete_sql)) {
        // Bind the user_id parameter to prevent SQL injection
        $delete_stmt->bind_param("i", $user_id);
        if ($delete_stmt->execute()) {
            // If deletion is successful, clear and destroy the session
            session_unset(); // Remove all session variables
            session_destroy(); // Terminate the session

            // Redirect to the home page with a success message
            header("Location: home.php?message=Account successfully deleted");
            exit();
        } else {
            // Display error message if deletion fails
            echo "Error deleting user: " . $conn->error;
        }
        $delete_stmt->close();
    } else {
        // Display error if the delete statement preparation fails
        echo "Error preparing the delete statement: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // If the user is not logged in, redirect to the home page
    header("Location: home.php");
    exit();
}
?>