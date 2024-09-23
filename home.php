<?php
session_start();
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest'; // Ako nema korisnika, prikazuje 'Guest'

if (isset($_GET['message'])) {
    echo "<p style='color: green; text-align: center;'>" . htmlspecialchars($_GET['message']) . "</p>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="generalDecor.css">
    <script src="generalScripts.js"></script>
    <script src="home.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>HOME</title>

</head>

<body>
    <?php include 'sidebar.php'; ?>

    <header>
        <h1 id="mainTitle">Home and M. K.</h1>
        <span id="welcome-text">Welcome <?php echo htmlspecialchars($user_name); ?>!</span>
    </header>

    <div id="menuIcon">
        <span onclick="toggleNav()">&#9776; Menu</span>
    </div>

    <div id="dataContainer"></div>

    <div id="gallery">
        <!-- Image 1 -->
        <img class="cvImages" src="placeholder.png" onclick="showResumeContent('placeholder.png', 'resumeContent1')">
        
        <div id="resumeContent1" class="resumeContent">
            <!-- Content for Image 1 -->
        </div>
    </div>
    
</body>
</html>
