<?php
session_start();

header('Content-Type: application/json');

// Provjeri je li korisnik prijavljen
if (!isset($_SESSION['userId'])) {
    echo json_encode([
        'success' => false,
        'message' => 'You need to log in to send a message.'
    ]);
    exit;
}

$user_id = $_SESSION['userId'];
$user_name = $_SESSION['user_name'];

// Provjera je li zahtjev POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dobivanje podataka iz JSON-a
    $data = json_decode(file_get_contents('php://input'), true);
    $message = $data['description'];

    // Database credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cv_data";

    // Povezivanje na bazu podataka
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Provjera povezivanja
    if ($conn->connect_error) {
        echo json_encode([
            'success' => false,
            'message' => 'Connection failed: ' . $conn->connect_error
        ]);
        exit;
    }

    // SQL upit za unos poruke u bazu
    $sql = "INSERT INTO msg (sent_by_userID, message) VALUES (?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("is", $user_id, $message);

        // Provjera je li SQL upit uspješno izvršen
        if ($stmt->execute()) {
            // Zabilježi akciju u admin_logs
            $log_text = "User $user_name has sent a message to the admin.";
            $log_sql = "INSERT INTO admin_logs (user_id, text_of_changes, created_at) VALUES (?, ?, NOW())";
            
            if ($log_stmt = $conn->prepare($log_sql)) {
                $log_stmt->bind_param("is", $user_id, $log_text);
                $log_stmt->execute();
                $log_stmt->close();
            }

            echo json_encode([
                'success' => true,
                'message' => 'Message sent successfully!'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $stmt->error
            ]);
        }

        $stmt->close();
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error preparing statement: ' . $conn->error
        ]);
    }

    $conn->close();
}
?>
