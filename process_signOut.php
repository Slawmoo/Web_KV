<?php
session_start(); // Pokreni sesiju

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_data";

// Provjeri je li korisnik prijavljen
if (isset($_SESSION['userId'])) {
    // Spremi podatke korisnika za logiranje
    $user_id = $_SESSION['userId'];
    $user_name = $_SESSION['user_name']; // Pretpostavlja se da je korisničko ime spremljeno u sesiji

    // Spajanje na bazu podataka
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Logiraj odjavu korisnika u admin_logs
    $log_text = "User logged out: " . $user_name;
    $log_sql = "INSERT INTO admin_logs (user_id, text_of_changes, created_at) VALUES (?, ?, NOW())";
    if ($log_stmt = $conn->prepare($log_sql)) {
        $log_stmt->bind_param("is", $user_id, $log_text);
        $log_stmt->execute();
        $log_stmt->close();
    }

    // Zatvori konekciju
    $conn->close();
}

// Obriši sve podatke u sesiji
session_unset();

// Uništi sesiju
session_destroy();

// Preusmjeri korisnika na početnu stranicu s obaviješću "Welcome Guest"
header("Location: home.php?user=Guest");
exit();
?>
