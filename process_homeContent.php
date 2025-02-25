<?php
// Set the response content type to JSON
header('Content-Type: application/json');

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_data";

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection failed and return a JSON error response if so
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Check if the request method is POST (form submission)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize the posted data
    $id = $_POST['id']; // Get the unique ID of the section to update
    $section_title = $conn->real_escape_string($_POST['section_title']); // Escape title to prevent SQL injection
    $section_content = $conn->real_escape_string($_POST['section_content']); // Escape content to prevent SQL injection

    // Prepare an SQL statement to update the section in the home_content table
    $stmt = $conn->prepare("UPDATE home_content SET section_title = ?, section_content = ? WHERE id = ?");
    // Bind parameters: s (string) for title and content, i (integer) for ID
    $stmt->bind_param("ssi", $section_title, $section_content, $id);

    // Execute the update statement and return the result as JSON
    if ($stmt->execute()) {
        // Success response if the update is successful
        echo json_encode(['success' => true, 'message' => "Content updated successfully."]);
    } else {
        // Error response if the update fails
        echo json_encode(['success' => false, 'message' => "Error updating content."]);
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>