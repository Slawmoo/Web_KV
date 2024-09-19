<?php
session_start(); // Pokreni sesiju

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_data";

// Provjeri je li korisnik prijavljen
if (isset($_SESSION['userId'])) {
    // Spremi podatke korisnika
    $user_id = $_SESSION['userId'];
    $user_name = $_SESSION['user_name'];
    $user_email = $_SESSION['userEmail'];

    // Spajanje na bazu podataka
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Logiraj brisanje korisnika u admin_logs
    $log_text = "User deleted account: " . $user_name;
    $log_sql = "INSERT INTO admin_logs (user_id, text_of_changes, created_at) VALUES (?, ?, NOW())";
    if ($log_stmt = $conn->prepare($log_sql)) {
        $log_stmt->bind_param("is", $user_id, $log_text);
        $log_stmt->execute();
        $log_stmt->close();
    }

    // SQL upit za brisanje korisnika iz baze
    $delete_sql = "DELETE FROM users WHERE id = ?";
    if ($delete_stmt = $conn->prepare($delete_sql)) {
        $delete_stmt->bind_param("i", $user_id);
        if ($delete_stmt->execute()) {
            // Ako je korisnik uspješno izbrisan, obriši i sesiju

            // Obriši sve podatke u sesiji
            session_unset();
            // Uništi sesiju
            session_destroy();

            // Preusmjeri korisnika na početnu stranicu s obaviješću o uspješnom brisanju
            header("Location: home.php?message=Account successfully deleted");
            exit();
        } else {
            echo "Error deleting user: " . $conn->error;
        }
        $delete_stmt->close();
    } else {
        echo "Error preparing the delete statement: " . $conn->error;
    }

    // Zatvori konekciju s bazom
    $conn->close();
} else {
    // Ako korisnik nije prijavljen, preusmjeri na početnu stranicu
    header("Location: home.php");
    exit();
}
?>
