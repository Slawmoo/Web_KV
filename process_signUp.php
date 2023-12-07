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

// Retrieve form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $description = $_POST["description"];
    $company = $_POST["company"];
}

// Insert data into the database
$sql = "INSERT INTO users (email, password, description, company) VALUES ('$email', '$password', '$description', '$company')";

if ($conn->query($sql) === TRUE) {
    $conn->close();
    // Redirect the user to home.html
    header("Location: signIn.html");
    exit(); // Make sure to exit to prevent further script execution
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>
