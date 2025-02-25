<?php
// Start the session to access user authentication data
session_start();

// Check if the request method is POST (form submission)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verify if the user is an admin (isAdmin != 0)
    if ($_SESSION['isAdmin'] != 0) {
        // Retrieve the new section title and content from the POST request
        $section_title = $_POST['section_title'];
        $section_content = $_POST['section_content'];

        // Database connection setup
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "cv_data";

        // Establish a new MySQLi connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check for connection errors and terminate if failed
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare an SQL statement to insert the new section into the home_content table
        $stmt = $conn->prepare("INSERT INTO home_content (section_title, section_content) VALUES (?, ?)");
        // Bind the parameters to prevent SQL injection (s = string)
        $stmt->bind_param("ss", $section_title, $section_content);
        
        // Execute the statement and handle the result
        if ($stmt->execute()) {
            // Get the ID of the newly inserted section
            $new_id = $conn->insert_id;

            // Send a JSON response with the new section ID for client-side use
            echo json_encode(['new_id' => $new_id]);
        } else {
            // Send a JSON error response if the insertion fails
            echo json_encode(['error' => 'Error adding new section']);
        }

        // Close the prepared statement and database connection
        $stmt->close();
        $conn->close();
    } else {
        // Send a JSON error response if the user is not an admin
        echo json_encode(['error' => 'Unauthorized']);
    }
}
?>s