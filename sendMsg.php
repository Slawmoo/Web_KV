<?php
session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sendMsg.css">
    <link rel="stylesheet" href="generalDecor.css">
    <script src="generalScripts.js"></script>
    <script src="sendMsg.js"></script>
    <title>Send Message</title>
    
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <header>
        <h1>Send Querry To Owner</h1>
    </header>
    <div id="menuIcon">
        <span onclick="toggleNav()">&#9776; Menu</span>
    </div>

    <div id="sendMessage">
        <form id="sendMessageForm" action="process_sendMsg.php" method="post" >
            <label for="description">Email content:</label>
            <textarea id="description" name="description" rows="10" maxlength="200" placeholder="Enter message for owner" required></textarea>            
            <input type="submit" value="Send">
          </form> 
    </div>
    
</body>
</html>
