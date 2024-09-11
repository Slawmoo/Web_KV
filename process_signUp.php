<?php
// Spajanje na bazu podataka
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_data";

// Kreiraj konekciju
$conn = new mysqli($servername, $username, $password, $dbname);

// Provjeri konekciju
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Uhvati podatke iz POST zahtjeva
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $description = $conn->real_escape_string($_POST['description']);
    $company = $conn->real_escape_string($_POST['company']);

    // Validacija lozinke na serveru
    if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$/", $password)) {
        die("Password does not meet the required complexity.");
    }

    // Provjera je li e-mail već registriran
    $checkEmail = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($checkEmail->num_rows > 0) {
        die("Email is already registered.");
    }

    // Ako je e-mail jedinstven i lozinka valjana, hashiraj lozinku i unesi podatke
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (email, password, description, company, isAdmin) VALUES ('$email', '$hashedPassword', '$description', '$company', 0)";

    if ($conn->query($sql) === TRUE) {
        header("Location: signIn.html?status=success");
        exit(); 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Zatvori konekciju
$conn->close();
?>
