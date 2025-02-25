<?php
// Start the session to access user data
session_start();

// Set the response content type to JSON
header('Content-Type: application/json');

// Check if the user is logged in by verifying userId in session
if (!isset($_SESSION['userId'])) {
    // Return JSON error if user is not logged in and exit
    echo json_encode([
        'success' => false,
        'message' => 'You need to log in to send a message.'
    ]);
    exit;
}

// Retrieve user data from session
$user_id = $_SESSION['userId'];
$user_name = $_SESSION['user_name'];

// Check if the request method is POST (form submission)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the JSON data from the request body and decode it
    $data = json_decode(file_get_contents('php://input'), true);
    $message = $data['description'];

    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cv_data";

    // Establish a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check for connection errors and return JSON error if failed
    if ($conn->connect_error) {
        echo json_encode([
            'success' => false,
            'message' => 'Connection failed: ' . $conn->connect_error
        ]);
        exit;
    }

    // Prepare an SQL statement to insert the message into the msg table
    $sql = "INSERT INTO msg (sent_by_userID, message) VALUES (?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters: i (integer) for user_id, s (string) for message
        $stmt->bind_param("is", $user_id, $message);

        // Execute the statement and handle the result
        if ($stmt->execute()) {
            // Log the action in the admin_logs table
            $log_text = "User $user_name has sent a message to the admin.";
            $log_sql = "INSERT INTO admin_logs (user_id, text_of_changes, created_at) VALUES (?, ?, NOW())";
            
            if ($log_stmt = $conn->prepare($log_sql)) {
                // Bind parameters for logging: i (integer) for user_id, s (string) for log text
                $log_stmt->bind_param("is", $user_id, $log_text);
                $log_stmt->execute();
                $log_stmt->close();
            }

            // Return success response
            echo json_encode([
                'success' => true,
                'message' => 'Message sent successfully!'
            ]);
        } else {
            // Return error response if message insertion fails
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $stmt->error
            ]);
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Return error response if statement preparation fails
        echo json_encode([
            'success' => false,
            'message' => 'Error preparing statement: ' . $conn->error
        ]);
    }

    // Close the database connection
    $conn->close();
}
?>