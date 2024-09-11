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
        <h1>Send Querry To Owner</h1>
    </header>
    <div id="menuIcon">
        <span onclick="toggleNav()">&#9776; Menu</span>
    </div>
    <!-- <div id="buttons">
        <button id="button1">Send Message</button>
        <button id="button2">FAQ</button>
        
    </div>-->
    <div id="userDataContainer">
    
    </div>
    <div id="sendMessage">
        <form id="sendMessageForm" action="sendMsg.php" method="post" >
            <label for="description">Email content:</label>
            <textarea id="description" name="description" rows="10" maxlength="200" placeholder="Enter message for owner" required></textarea>            
            <input type="submit" value="Send">
          </form> 
    </div>
    
</body>
</html>
