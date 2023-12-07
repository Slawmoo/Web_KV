<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION["user_id"])) {
    // Send an error response or redirect to the login page
    header('HTTP/1.1 401 Unauthorized');
    exit();
}

// Fetch data from the session
$userData = array(
    "id" => $_SESSION["user_id"],
    "name" => $_SESSION["user_name"],
    "email" => $_SESSION["user_email"],
    "description" => $_SESSION["user_description"],
    "company" => $_SESSION["user_company"]
);

// Send the user data as a JSON response
header('Content-Type: application/json');
echo json_encode($userData);
?>
