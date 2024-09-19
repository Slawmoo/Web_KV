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

// Spajanje na bazu
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Provjera je li POST zahtjev za brisanje računa
if (isset($_POST['delete_account']) && $_POST['delete_account'] === 'true') {
    // SQL upit za brisanje korisnika
    $sql = "DELETE FROM users WHERE email = '$userEmail'";

    if ($conn->query($sql) === TRUE) {
        // Zabilježi brisanje računa u admin_logs
        $log_text = "User with email $userEmail has deleted their account.";
        $log_sql = "INSERT INTO admin_logs (user_id, text_of_changes, created_at) VALUES ((SELECT id FROM users WHERE email='$userEmail'), ?, NOW())";

        if ($log_stmt = $conn->prepare($log_sql)) {
            $log_stmt->bind_param("s", $log_text);
            $log_stmt->execute();
            $log_stmt->close();
        } else {
            echo "Error logging the change: " . $conn->error;
        }

        // Uništi sesiju nakon brisanja
        session_unset();
        session_destroy();

        // Preusmjeri korisnika na početnu stranicu
        header("Location: home.php?user=Guest");
        exit();
    } else {
        echo "Error deleting account: " . $conn->error;
    }
}

// Spremanje ažuriranih podataka u bazu
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['delete_account'])) {
    $newName = $_POST['user_name'];
    $newEmail = $_POST['userEmail'];
    $newCompany = $_POST['userCompany'];
    $newDescription = $_POST['userDescription'];

    // SQL upit za ažuriranje podataka
    $sql = "UPDATE users SET user_name='$newName', email='$newEmail', company='$newCompany', description='$newDescription' WHERE email='$userEmail'";

    if ($conn->query($sql) === TRUE) {
        // Ažuriraj session podatke
        $_SESSION['user_name'] = $newName;
        $_SESSION['userEmail'] = $newEmail;
        $_SESSION['userCompany'] = $newCompany;
        $_SESSION['userDescription'] = $newDescription;

        // Zabilježi promjenu u admin_logs
        $log_text = "User with email $userEmail has updated their profile.";
        $log_sql = "INSERT INTO admin_logs (user_id, text_of_changes, created_at) VALUES ((SELECT id FROM users WHERE email='$newEmail'), ?, NOW())";

        if ($log_stmt = $conn->prepare($log_sql)) {
            $log_stmt->bind_param("s", $log_text);
            $log_stmt->execute();
            $log_stmt->close();
        } else {
            echo "Error logging the change: " . $conn->error;
        }
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // Zatvaranje konekcije
    $conn->close();
    
    // Preusmjeri korisnika na početnu stranicu
    header("Location: home.php");
    exit();
}

$conn->close();
?>
