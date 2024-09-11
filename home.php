<?php
session_start();
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest'; // Ako nema korisnika, prikazuje 'Guest'

/*// Check if the user is logged in (session variables are set)
if (isset($_SESSION["user_id"])) {
    // Display user profile
    echo "Welcome, " . $_SESSION["user_name"] . "!<br>";
    echo "Email: " . $_SESSION["user_email"] . "<br>";
    echo "Description: " . $_SESSION["user_description"] . "<br>";
    echo "Company: " . $_SESSION["user_company"] . "<br>";
} else {
    echo "Sign in to send message to owner!";
    
}*/
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
    <style>/* Stil za desno poravnat tekst u zaglavlju */
        #welcome-text {
        float: right;
        font-size: 23px;
        color: #FFE500;
        margin-right: 20px;
    }   
    </style>
</head>

<body>
    <!-- Add To Sidebar -->
    <div id="sidebar">
        <a href="home.php">Home</a>
        <a href="sendMsg.html">Send Message</a>
        <a href="signUp.php">Sign Up</a>
        <a href="signIn.html">Sign In</a>
        <a href="signOut.html">Sign Out</a>
        <a href="FAQ.html">FAQ</a>
        <a href="#" onclick="closeNav()">Close Menu</a>
    </div>

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
