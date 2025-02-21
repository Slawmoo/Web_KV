<?php
session_start();
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_data";

// Set up error handling to not output HTML
ini_set('display_errors', 0);
error_reporting(E_ALL);

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_SESSION['user_id'])) {
            throw new Exception("You must be logged in to comment.");
        }

        $section_id = $_POST['section_id'];
        $user_id = $_SESSION['user_id'];
        $comment_text = $conn->real_escape_string($_POST['comment_text']);
        $created_at = date('Y-m-d H:i:s');

        // Insert comment into the database
        $stmt = $conn->prepare("INSERT INTO section_comments (section_id, user_id, comment_text, created_at, updated_at) VALUES (?, ?, ?, ?, ?)");
        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("iisss", $section_id, $user_id, $comment_text, $created_at, $created_at);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'comment_text' => $comment_text, 'created_at' => $created_at]);
        } else {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        $stmt->close();
    }

    $conn->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
