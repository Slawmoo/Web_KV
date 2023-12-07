<?php
session_start();

// Check if the user is logged in (session variables are set)
if (isset($_SESSION["user_id"])) {
    // Display user profile
    echo "Welcome, " . $_SESSION["user_name"] . "!<br>";
    echo "Email: " . $_SESSION["user_email"] . "<br>";
    echo "Description: " . $_SESSION["user_description"] . "<br>";
    echo "Company: " . $_SESSION["user_company"] . "<br>";
} else {
    
    echo "Sign in to send message to owner!";
    exit();
}
?>