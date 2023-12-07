<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_data";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Validate user credentials
        $sql = "SELECT id, name, email, description, company FROM users WHERE email = '$email' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Authentication successful
            $userData = $result->fetch_assoc();

            // Store user data in the session
            $_SESSION["user_id"] = $userData["id"];
            $_SESSION["user_name"] = $userData["name"];
            $_SESSION["user_email"] = $userData["email"];
            $_SESSION["user_description"] = $userData["description"];
            $_SESSION["user_company"] = $userData["company"];

            //redirect
            header("Location: sendMsg.html");
            exit();
    } else {
            // Authentication failed
            echo "Invalid email or password";
        }
}

// Close the database connection
$conn->close();

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
