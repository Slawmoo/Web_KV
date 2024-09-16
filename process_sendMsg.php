<?php
session_start();

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_data";

// Provjeri je li korisnik prijavljen
if (isset($_SESSION['userId'])) {
    $user_id = $_SESSION['userId'];  // Dohvati ID korisnika iz session-a
} else {
    echo "<script>alert('You need to log in to send a message.'); window.location.href = 'login.php';</script>";
    exit;
}

// Provjera je li forma poslana
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prikupljanje podataka iz forme
    $message = $_POST['description'];

    // Povezivanje na bazu podataka
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Provjera povezivanja
    if ($conn->connect_error) {
        echo "<script>alert('Connection failed: " . $conn->connect_error . "');</script>";
        exit;
    }

    // SQL upit za unos podataka u tablicu msg
    $sql = "INSERT INTO msg (sent_by_userID, message) VALUES (?, ?)";
    
    // Priprema SQL upita
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("is", $user_id, $message);

        // Izvršavanje SQL upita
        if ($stmt->execute()) {
            echo "<script>alert('Message sent successfully!'); window.location.href = 'sendMsg.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }

        // Zatvori pripremljeni upit
        $stmt->close();
    } else {
        echo "<script>alert('Error preparing statement: " . $conn->error . "');</script>";
    }

    // Zatvaranje konekcije
    $conn->close();
}
?>
