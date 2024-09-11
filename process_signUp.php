<?php
// Spajanje na bazu podataka
$servername = "localhost"; // Ili IP adresa servera
$username = "root"; // Korisničko ime baze
$password = ""; // Lozinka baze (ostavi prazno ako nema lozinke)
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
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash lozinke radi sigurnosti
    $description = $conn->real_escape_string($_POST['description']);
    $company = $conn->real_escape_string($_POST['company']);

    // Unos podataka u bazu
    $sql = "INSERT INTO users (email, password, description, company, isAdmin) VALUES ('$email', '$password', '$description', '$company', 0)";

    if ($conn->query($sql) === TRUE) {
        // Uspješno izvršeno - redirekcija s parametrom
        header("Location: signIn.html?status=success");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
// Zatvori konekciju
$conn->close();
?>
