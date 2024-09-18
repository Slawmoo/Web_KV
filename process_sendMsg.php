<?php
session_start();

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_data";

// Provjeri je li korisnik prijavljen
if (isset($_SESSION['userId'])) {
    $user_id = $_SESSION['userId'];  // Dohvati detalje korisnika iz session-a
    $user_name = $_SESSION['user_name'];
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
            // Ako je poruka uspješno poslana, zabilježi akciju u admin_logs
            $log_text = "User $user_name has sent a message to the admin.";
            $log_sql = "INSERT INTO admin_logs (user_id, text_of_changes, created_at) VALUES (?, ?, NOW())";
            
            if ($log_stmt = $conn->prepare($log_sql)) {
                $log_stmt->bind_param("is", $user_id, $log_text);
                $log_stmt->execute();
                $log_stmt->close();
            } else {
                echo "<script>alert('Error logging the action: " . $conn->error . "');</script>";
            }

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
