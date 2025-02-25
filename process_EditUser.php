<?php
// Start the session to access and manage user data
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_data";

// Check if the user is logged in by verifying session variables
if (isset($_SESSION['user_name']) && isset($_SESSION['userEmail']) && isset($_SESSION['userCompany']) && isset($_SESSION['userDescription'])) {
    // Assign session data to variables for use in the script
    $user_name = $_SESSION['user_name'];
    $userEmail = $_SESSION['userEmail'];
    $userCompany = $_SESSION['userCompany'];
    $userDescription = $_SESSION['userDescription'];
} else {
    // Return JSON error and exit if user data is missing
    echo json_encode(['status' => 'error', 'message' => 'No user data found.']);
    exit;
}

// Establish a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors and terminate if failed
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST request for account deletion
if (isset($_POST['action']) && $_POST['action'] === 'delete_account') {
    // Prepare SQL query to delete the user based on email
    $sql = "DELETE FROM users WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $userEmail);
        if ($stmt->execute()) {
            // Log the account deletion in admin_logs
            $log_text = "User with email $userEmail has deleted their account.";
            $log_sql = "INSERT INTO admin_logs (user_id, text_of_changes, created_at) VALUES ((SELECT id FROM users WHERE email = ?), ?, NOW())";
            if ($log_stmt = $conn->prepare($log_sql)) {
                $log_stmt->bind_param("ss", $userEmail, $log_text);
                $log_stmt->execute();
                $log_stmt->close();
            }

            // Clear and destroy the session after deletion
            session_unset();
            session_destroy();

            // Return success response
            echo json_encode(['status' => 'success', 'message' => 'Account deleted.']);
        } else {
            // Return error response if deletion fails
            echo json_encode(['status' => 'error', 'message' => 'Error deleting account: ' . $conn->error]);
        }
        $stmt->close();
    }
    exit;
}

// Handle POST request for updating profile data
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['action'])) {
    // Retrieve new data from POST request
    $newName = $_POST['user_name'];
    $newEmail = $_POST['userEmail'];
    $newCompany = $_POST['userCompany'];
    $newDescription = $_POST['userDescription'];

    // Prepare SQL query to update user data
    $sql = "UPDATE users SET user_name = ?, email = ?, company = ?, description = ? WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters to prevent SQL injection
        $stmt->bind_param("sssss", $newName, $newEmail, $newCompany, $newDescription, $userEmail);
        if ($stmt->execute()) {
            // Update session data with new values
            $_SESSION['user_name'] = $newName;
            $_SESSION['userEmail'] = $newEmail;
            $_SESSION['userCompany'] = $newCompany;
            $_SESSION['userDescription'] = $newDescription;

            // Log the profile update in admin_logs
            $log_text = "User with email $userEmail has updated their profile.";
            $log_sql = "INSERT INTO admin_logs (user_id, text_of_changes, created_at) VALUES ((SELECT id FROM users WHERE email = ?), ?, NOW())";
            if ($log_stmt = $conn->prepare($log_sql)) {
                $log_stmt->bind_param("ss", $newEmail, $log_text);
                $log_stmt->execute();
                $log_stmt->close();
            }

            // Return success response
            echo json_encode(['status' => 'success', 'message' => 'Profile updated.']);
        } else {
            // Return error response if update fails
            echo json_encode(['status' => 'error', 'message' => 'Error updating record: ' . $conn->error]);
        }
        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>