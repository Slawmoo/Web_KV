<?php
session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signIn.css">
    <link rel="stylesheet" href="generalDecor.css">
    <script src="generalScripts.js"></script>
    <script src="signIn.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Sign In</title>
    
</head>
<script>
    // Funkcija koja dobiva vrijednost parametra iz URL-a
    function getQueryParam(param) {
        let urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    // Provjerava je li status jednak 'success'
    window.onload = function() {
        if (getQueryParam('status') === 'success') {
            alert("Profile successfully created!");
        }
    };
</script>
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
        <h1>SIGN IN</h1>
    </header>
    <div id="menuIcon">
        <span onclick="toggleNav()">&#9776; Menu</span>
    </div>
    
    <div id="singInFormDiv">
        <form id="signInForm" action="process_signIn.php" method="post" >
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password</label>
            <input type="password" id="pass" name="password" required>
            <input type="submit" value="SIGN IN">
          </form> 
    </div>
</body>
</html>
