<?php
// Start the session to access user data
session_start();
// Set the response content type to JSON
header('Content-Type: application/json');

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_data";

try {
    // Attempt to establish a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check if the connection failed and throw an exception if so
    if ($conn->connect_error) {
        throw new Exception("Povezivanje s bazom nije uspjelo: " . $conn->connect_error);
    }

    // Check if the request method is POST (form submission)
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Verify if the user is logged in by checking for user_id in session
        if (!isset($_SESSION['user_id'])) {
            throw new Exception("Morate biti prijavljeni da biste komentirali.");
        }

        // Retrieve and sanitize POST data
        $section_id = $_POST['section_id'];
        $user_id = $_SESSION['user_id'];
        $comment_text = $conn->real_escape_string($_POST['comment_text']); // Escape to prevent SQL injection
        $created_at = date('Y-m-d H:i:s'); // Current timestamp for creation and update

        // Prepare and execute an SQL statement to insert the new comment
        $stmt = $conn->prepare("INSERT INTO section_comments (section_id, user_id, comment_text, created_at, updated_at) VALUES (?, ?, ?, ?, ?)");
        // Bind parameters: i (integer) for IDs, s (string) for text and dates
        $stmt->bind_param("iisss", $section_id, $user_id, $comment_text, $created_at, $created_at);
        $stmt->execute();
        $stmt->close();

        // Fetch all comments for the given section, joined with user names
        $comments_query = $conn->query("SELECT section_comments.*, users.user_name 
                                       FROM section_comments 
                                       JOIN users ON section_comments.user_id = users.id 
                                       WHERE section_id = $section_id 
                                       ORDER BY created_at DESC");

        // Build HTML string for comments
        $comments_html = '';
        while ($comment = $comments_query->fetch_assoc()) {
            $comment_id = $comment['id'];
            $formatted_date = date('H:i:s d.m.Y.', strtotime($comment['created_at']));
            // Append each comment as an HTML block, escaping output for security
            $comments_html .= "
                <div class='comment' data-comment-id='$comment_id'>
                    <p>" . htmlspecialchars($comment['comment_text']) . "</p>
                    <small>" . htmlspecialchars($comment['user_name']) . " posted on: " . $formatted_date . "</small>
                </div>";
        }

        // Send a JSON response with success status and rendered comments HTML
        echo json_encode([
            'success' => true,
            'comments_html' => $comments_html
        ]);

        // Close the database connection
        $conn->close();
    }
} catch (Exception $e) {
    // Catch any exceptions and return a JSON error response
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>