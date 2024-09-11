<?php
session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="faq.css">
    <link rel="stylesheet" href="generalDecor.css">
    <script src="generalScripts.js"></script>
    <script src="faq.js"></script>
    <title>FAQ</title>
    
</head>
<body>
    <!-- Add To Sidebar -->
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
        <h1>Frequently Asked Questions</h1>
    </header>
    <div id="menuIcon">
        <span onclick="toggleNav()">&#9776; Menu</span>
    </div>

    <div id="questions">
        <!-- question1 -->
        <img class="Answers" alt="Image 1" onclick="showAnswer(answer1)">
        <div id="answer1" class="resumeContent">
            
        </div>

        <!-- question1 -->
        <img class="Answers" alt="Image 1" onclick="showAnswer(answer1)">
        <div id="answer1" class="resumeContent">
            
        </div>
        <!-- question1 -->
        <img class="Answers" alt="Image 1" onclick="showAnswer(answer1)">
        <div id="answer1" class="resumeContent">
            
        </div>
        <!-- Add more images as needed -->
    </div>
    
</body>
</html>
