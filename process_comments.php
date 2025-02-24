<?php
session_start();
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_data";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Povezivanje s bazom nije uspjelo: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_SESSION['user_id'])) {
            throw new Exception("Morate biti prijavljeni da biste komentirali.");
        }

        $section_id = $_POST['section_id'];
        $user_id = $_SESSION['user_id'];
        $comment_text = $conn->real_escape_string($_POST['comment_text']);
        $created_at = date('Y-m-d H:i:s');

        // Pohrana novog komentara
        $stmt = $conn->prepare("INSERT INTO section_comments (section_id, user_id, comment_text, created_at, updated_at) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $section_id, $user_id, $comment_text, $created_at, $created_at);
        $stmt->execute();
        $stmt->close();

        // Dohvaćanje svih komentara za sekciju
        $comments_query = $conn->query("SELECT section_comments.*, users.user_name 
                                       FROM section_comments 
                                       JOIN users ON section_comments.user_id = users.id 
                                       WHERE section_id = $section_id 
                                       ORDER BY created_at DESC");

        $comments_html = '';
        while ($comment = $comments_query->fetch_assoc()) {
            $comment_id = $comment['id'];
            $formatted_date = date('H:i:s d.m.Y.', strtotime($comment['created_at']));
            $comments_html .= "
                <div class='comment' data-comment-id='$comment_id'>
                    <p>" . htmlspecialchars($comment['comment_text']) . "</p>
                    <small>" . htmlspecialchars($comment['user_name']) . " posted on: " . $formatted_date . "</small>
                </div>";
        }

        echo json_encode([
            'success' => true,
            'comments_html' => $comments_html
        ]);

        $conn->close();
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>