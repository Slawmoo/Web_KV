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

if (isset($_GET['section_title'])) {
    $section_title = $_GET['section_title'];
    $stmt = $conn->prepare("SELECT section_content FROM home_content WHERE section_title = ?");
    $stmt->bind_param("s", $section_title);
    $stmt->execute();
    $stmt->bind_result($section_content);
    $stmt->fetch();
    echo htmlspecialchars($section_content);
    $stmt->close();
}

$conn->close();
?>
