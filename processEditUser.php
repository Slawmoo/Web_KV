<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_data";

// Provjera je li korisnik prijavljen
if (isset($_SESSION['user_name']) && isset($_SESSION['userEmail']) && isset($_SESSION['userCompany']) && isset($_SESSION['userDescription'])) {
    $user_name = $_SESSION['user_name'];
    $userEmail = $_SESSION['userEmail'];
    $userCompany = $_SESSION['userCompany'];
    $userDescription = $_SESSION['userDescription'];
} else {
    echo "No user data found.";
    exit;
}

// Spremanje ažuriranih podataka u bazu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newName = $_POST['user_name'];
    $newEmail = $_POST['userEmail'];
    $newCompany = $_POST['userCompany'];
    $newDescription = $_POST['userDescription'];

    // Spajanje na bazu
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL upit za ažuriranje podataka
    $sql = "UPDATE users SET user_name='$newName', email='$newEmail', company='$newCompany', description='$newDescription' WHERE email='$userEmail'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        // Ažuriraj session podatke
        $_SESSION['user_name'] = $newName;
        $_SESSION['userEmail'] = $newEmail;
        $_SESSION['userCompany'] = $newCompany;
        $_SESSION['userDescription'] = $newDescription;
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
    // Preusmjeri korisnika na početnu stranicu
    header("Location: home.php");
    exit();
}
?>