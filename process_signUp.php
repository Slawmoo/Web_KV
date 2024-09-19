<?php
session_start(); // Pokretanje sesije

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
    $user_name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $description = $conn->real_escape_string($_POST['description']);
    $company = $conn->real_escape_string($_POST['company']);

    // Provjera je li e-mail već registriran
    $checkEmail = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($checkEmail->num_rows > 0) {
        // Ako e-mail već postoji, postavi grešku u sesiju
        $_SESSION['error'] = "Email is already registered.";
        header("Location: signUp.php"); // Ponovno učitaj formu
        exit();
    }

    // Validacija lozinke na serveru
    if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$/", $password)) {
        $_SESSION['error'] = "Password does not meet the required complexity.";
        header("Location: signUp.php");
        exit();
    }

    // Ako je e-mail jedinstven i lozinka valjana, hashiraj lozinku i unesi podatke
    $hashedPassword = crypt($password, "2xw");

    $sql = "INSERT INTO users (user_name, email, password, description, company, isAdmin) VALUES ('$user_name','$email', '$hashedPassword', '$description', '$company', 0)";

    if ($conn->query($sql) === TRUE) {
        // Unos uspješne registracije u admin_logs
        $log_text = "New user registered: $user_name ($email)";
        $log_sql = "INSERT INTO admin_logs (user_id, text_of_changes, created_at) VALUES ((SELECT id FROM users WHERE email = '$email'), ?, NOW())";
        
        if ($log_stmt = $conn->prepare($log_sql)) {
            $log_stmt->bind_param("s", $log_text);
            $log_stmt->execute();
            $log_stmt->close();
        }

        header("Location: home.php?status=success");
        exit(); 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Zatvori konekciju
$conn->close();
?>
