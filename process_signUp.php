<?php
// Start the session to manage error messages and user data
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_data";

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors and terminate if failed
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST (form submission)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize POST data to prevent SQL injection
    $user_name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password']; // Not escaped yet, will be hashed
    $description = $conn->real_escape_string($_POST['description']);
    $company = $conn->real_escape_string($_POST['company']);

    // Check if the email is already registered
    $checkEmail = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($checkEmail->num_rows > 0) {
        // If email exists, set an error in session and redirect to sign-up page
        $_SESSION['error'] = "Email is already registered.";
        header("Location: signUp.php");
        exit();
    }

    // Validate password complexity on the server side
    if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$/", $password)) {
        // If password doesn't meet requirements, set error and redirect
        $_SESSION['error'] = "Password does not meet the required complexity.";
        header("Location: signUp.php");
        exit();
    }

    // Hash the password for secure storage (replacing plain text)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Use modern hashing instead of plain text or crypt

    // Prepare an SQL statement to insert the new user, preventing SQL injection
    $sql = "INSERT INTO users (user_name, email, password, description, company, isAdmin) VALUES (?, ?, ?, ?, ?, 0)";
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters: s (string) for all fields except isAdmin, which is hardcoded as 0
        $stmt->bind_param("sssss", $user_name, $email, $hashedPassword, $description, $company);

        if ($stmt->execute()) {
            // Log the successful registration in admin_logs
            $log_text = "New user registered: $user_name ($email)";
            $log_sql = "INSERT INTO admin_logs (user_id, text_of_changes, created_at) VALUES ((SELECT id FROM users WHERE email = ?), ?, NOW())";
            
            if ($log_stmt = $conn->prepare($log_sql)) {
                $log_stmt->bind_param("ss", $email, $log_text);
                $log_stmt->execute();
                $log_stmt->close();
            }

            // Redirect to home page with success status
            header("Location: home.php?status=success");
            exit();
        } else {
            // Output error if insertion fails (for debugging; consider logging in production)
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $stmt->close();
    }

    // Close the database connection
    $conn->close();
}
?>