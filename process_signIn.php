<?php
session_start();
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_data";

try {
    // Create connection
    error_log("Connecting to the database...");
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    error_log("Database connection successful.");

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if (!$stmt) {
        throw new Exception("Statement preparation failed: " . $conn->error);
    }
    error_log("Statement prepared successfully.");

    // Get and sanitize input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    error_log("Input received and sanitized. Email: $email");

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        error_log("User found. Email: " . $row['email']);

        if ($password== $row['password']){// password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['userEmail'] = $row['email'];
            $_SESSION['userCompany'] = $row['company'];
            $_SESSION['userDescription'] = $row['description'];
            $_SESSION['isAdmin'] = $row['isAdmin'];

            // Log the login
            $log_stmt = $conn->prepare("INSERT INTO admin_logs (user_id, text_of_changes, created_at) VALUES (?, ?, NOW())");
            $log_text = "User logged in: " . $row['user_name'] . " (" . $row['email'] . ")";
            $log_stmt->bind_param("is", $row['id'], $log_text);
            $log_stmt->execute();
            $log_stmt->close();

            echo json_encode(['success' => true]);
            error_log("Login successful. User ID: " . $row['id']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Incorrect password!']);
            error_log("Incorrect password.");
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User with this email does not exist!']);
        error_log("User with email $email does not exist.");
    }

    $stmt->close();
    $conn->close();
    error_log("Database connection closed.");

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    error_log("Exception occurred: " . $e->getMessage());
}
?>
