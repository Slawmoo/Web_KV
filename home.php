<?php
session_start();
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest'; // Ako nema korisnika, prikazuje 'Guest'

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
        <img class="cvImages" src="placeholder.png" alt="Image 1" onclick="showResumeContent('placeholder.png', 'resumeContent1')">
        <div id="resumeContent1" class="resumeContent">
            <!-- Content for Image 1 -->
        </div>

        <!-- Image 2 -->
        <img class="cvImages" src="placeholder.png" alt="Image 2" onclick="showResumeContent('placeholder.png', 'resumeContent2')">
        <div id="resumeContent2" class="resumeContent">
            <!-- Content for Image 2 -->
        </div>

        <!-- Image 3 -->
        <img class="cvImages" src="placeholder.png" alt="Image 3" onclick="showResumeContent('placeholder.png', 'resumeContent3')">
        <div id="resumeContent3" class="resumeContent">
            <!-- Content for Image 3 -->
        </div>
        <!-- Add more images as needed -->
    </div>
    
</body>
</html>
