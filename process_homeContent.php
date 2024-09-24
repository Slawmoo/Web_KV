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
    $id = $_POST['id']; // Get the id of the section
    $section_title = $_POST['section_title'];
    $section_content = $_POST['section_content'];

    // Prepare an update statement using the unique id
    $stmt = $conn->prepare("UPDATE home_content SET section_title = ?, section_content = ? WHERE id = ?");
    $stmt->bind_param("ssi", $section_title, $section_content, $id);

    if ($stmt->execute()) {
        echo "Content updated successfully.";
    } else {
        echo "Error updating content.";
    }

    $stmt->close();
}

$conn->close();
?>
