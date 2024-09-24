<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if user is admin
    if ($_SESSION['isAdmin'] != 0) {
        // Fetch the new section title and content
        $section_title = $_POST['section_title'];
        $section_content = $_POST['section_content'];

        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "cv_data";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert the new section into the database
        $stmt = $conn->prepare("INSERT INTO home_content (section_title, section_content) VALUES (?, ?)");
        $stmt->bind_param("ss", $section_title, $section_content);
        if ($stmt->execute()) {
            // Get the last inserted ID
            $new_id = $conn->insert_id;

            // Return the new section ID as JSON response
            echo json_encode(['new_id' => $new_id]);
        } else {
            echo json_encode(['error' => 'Error adding new section']);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['error' => 'Unauthorized']);
    }
}
