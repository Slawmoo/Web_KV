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
    <div id="sidebar">
        <a href="home.php">Home</a>
        <a href="sendMsg.php">Send Message</a>
        <a href="signUp.php">Sign Up</a>
        <a href="signIn.php">Sign In</a>
        <a href="signOut.php">Sign Out</a>
        <a href="FAQ.php">FAQ</a>
        <a href="#" onclick="closeNav()">Close Menu</a>

        <!-- User Info Section -->
        <div id="userInfo">
            <div>ACCOUNT</div><br>
            <?php if (isset($_SESSION['user_name']) && isset($_SESSION['userEmail']) && isset($_SESSION['userCompany']) && isset($_SESSION['userDescription'])): ?>
                <div id="user_name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></div>
                <div id="userEmail"><?php echo htmlspecialchars($_SESSION['userEmail']); ?></div>
                <div id="userCompany"><?php echo htmlspecialchars($_SESSION['userCompany']); ?></div>
                <div id="userDescription" onclick="toggleDescription()">
                    <span id="shortDescription"><?php echo htmlspecialchars(substr($_SESSION['userDescription'], 0, 20)) . (strlen($_SESSION['userDescription']) > 20 ? '...' : ''); ?></span>
                    <span id="fullDescription"><?php echo htmlspecialchars($_SESSION['userDescription']); ?></span>
                </div>
            <?php else: ?>
                <div>Sign in to see information</div>
            <?php endif; ?>
        </div>
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
