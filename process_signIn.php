<?php
// Start the session to manage user authentication
session_start();
// Set the response content type to JSON
header('Content-Type: application/json');

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_data";

try {
    // Attempt to establish a database connection and log the action
    error_log("Connecting to the database...");
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check for connection errors and throw an exception if failed
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    error_log("Database connection successful.");

    // Prepare an SQL statement to select user by email, preventing SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if (!$stmt) {
        throw new Exception("Statement preparation failed: " . $conn->error);
    }
    error_log("Statement prepared successfully.");

    // Sanitize email input and retrieve password directly from POST
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    error_log("Input received and sanitized. Email: $email");

    // Bind the email parameter and execute the query
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user with the given email exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        error_log("User found. Email: " . $row['email']);

        // Verify the password (currently plain text comparison, should use password_verify)
        if ($password == $row['password']) { // Note: Should be password_verify($password, $row['password'])
            // Set session variables for the authenticated user
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['userEmail'] = $row['email'];
            $_SESSION['userCompany'] = $row['company'];
            $_SESSION['userDescription'] = $row['description'];
            $_SESSION['isAdmin'] = $row['isAdmin'];

            // Log the successful login in admin_logs
            $log_stmt = $conn->prepare("INSERT INTO admin_logs (user_id, text_of_changes, created_at) VALUES (?, ?, NOW())");
            $log_text = "User logged in: " . $row['user_name'] . " (" . $row['email'] . ")";
            $log_stmt->bind_param("is", $row['id'], $log_text);
            $log_stmt->execute();
            $log_stmt->close();

            // Return success response
            echo json_encode(['success' => true]);
            error_log("Login successful. User ID: " . $row['id']);
        } else {
            // Return error response for incorrect password
            echo json_encode(['success' => false, 'message' => 'Incorrect password!']);
            error_log("Incorrect password.");
        }
    } else {
        // Return error response if no user is found with the given email
        echo json_encode(['success' => false, 'message' => 'User with this email does not exist!']);
        error_log("User with email $email does not exist.");
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
    error_log("Database connection closed.");

} catch (Exception $e) {
    // Catch any exceptions and return a JSON error response
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    error_log("Exception occurred: " . $e->getMessage());
}
?>