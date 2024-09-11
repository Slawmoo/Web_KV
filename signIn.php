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

    <?php include 'sidebar.php'; ?>
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
