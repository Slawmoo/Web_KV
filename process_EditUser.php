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
    json_encode(['status' => 'error', 'message' => 'No user data found.']);
    exit;
}

// Spajanje na bazu
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Provjera je li POST zahtjev za brisanje računa
if (isset($_POST['action']) && $_POST['action'] === 'delete_account') {
    
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
             
        }

        // Uništi sesiju nakon brisanja
        session_unset();
        session_destroy();
        
         json_encode(['status' => 'success', 'message' => 'Account deleted.']);
    } else {
         json_encode(['status' => 'error', 'message' => 'Error deleting account: ' . $conn->error]);
    }
    exit;
}

// Spremanje ažuriranih podataka u bazu
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['action'])) {
    $newName = $_POST['user_name'];
    $newEmail = $_POST['userEmail'];
    $newCompany = $_POST['userCompany'];
    $newDescription = $_POST['userDescription'];

     "Form data received: $newName, $newEmail, $newCompany, $newDescription\n\n";

    // SQL upit za ažuriranje podataka
    $sql = "UPDATE users SET user_name='$newName', email='$newEmail', company='$newCompany', description='$newDescription' WHERE email='$userEmail'";
     "SQL Query: " . $sql . "\n\n";

    if ($conn->query($sql) === TRUE) {
         "Profile updated.\n\n";
        
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
             "Profile update logged.\n\n";
        } else {
             "Error logging the change: " . $conn->error . "\n\n";
        }

         json_encode(['status' => 'success', 'message' => 'Profile updated.']);
    } else {
         json_encode(['status' => 'error', 'message' => 'Error updating record: ' . $conn->error]);
    }
}
$conn->close();
?>
