<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_data";

try {
    // Kreiraj konekciju
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Provjeri konekciju
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Obrada podataka iz forme
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $conn->real_escape_string($_POST['email']);
        $password = $_POST['password'];
    
        // Provjera postoji li korisnik u bazi
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            // Provjera lozinke (koristi password_verify jer su lozinke hashirane)
            if (password_verify($password, $row['password'])) {
                // Postavi korisničko ime u sesiju
                $_SESSION['userId'] = $row['id'];
                $_SESSION['user_name'] = $row['user_name'];  
                $_SESSION['userEmail'] = $row['email'];
                $_SESSION['userCompany'] = $row['company'];
                $_SESSION['userDescription'] = $row['description']; 

                // Dodaj log zapis za prijavu korisnika
                $log_text = "User logged in: " . $row['user_name'] . " (" . $row['email'] . ")";
                $log_sql = "INSERT INTO admin_logs (user_id, text_of_changes, created_at) VALUES (?, ?, NOW())";
                if ($log_stmt = $conn->prepare($log_sql)) {
                    $log_stmt->bind_param("is", $row['id'], $log_text);
                    $log_stmt->execute();
                    $log_stmt->close();
                }

                // Preusmjeri korisnika na početnu stranicu
                header("Location: home.php");
                exit();
            } else {
                // Ako lozinka nije ispravna
                echo "Incorrect password!";
            }
        } else {
            // Ako korisnik s danim e-mailom ne postoji
            echo "User with this email does not exist!";
        }
    
        // Zatvori konekciju
        $conn->close();
    }

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
