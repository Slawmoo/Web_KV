<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_data";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the posted data
    $section_title = $_POST['section_title'];
    $section_content = $_POST['section_content'];

    // Prepare an update statement
    $stmt = $conn->prepare("UPDATE home_content SET section_content = ? WHERE section_title = ?");
    $stmt->bind_param("ss", $section_content, $section_title);

    if ($stmt->execute()) {
        echo "Content updated successfully.";
    } else {
        echo "Error updating content.";
    }

    $stmt->close();
}

$conn->close();
?>
