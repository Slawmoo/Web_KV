<?php
session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signOut.css">
    <link rel="stylesheet" href="generalDecor.css">
    <script src="signOut.js"></script>
    <script src="generalScripts.js"></script>
    <title>Sign Out</title>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <header>
        <h1>Do you really want to sign out?</h1>
    </header>
    <div id="menuIcon">
        <span onclick="toggleNav()">&#9776; Menu</span>
    </div>
    <div id="centarContent">
        <form action="process_signOut.php" method="post">
            <button type="submit" class="sign-out-button">Sign Out</button>
        </form>
    </div>
</body>
</html>
