<?php
session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="generalDecor.css">
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

<script>
    function signOut() {
    // Add your sign-out logic here
    alert('You have been signed out.');
    // Redirect to sign-in page or perform any other necessary actions
}
</script>

<style>
body {
  margin: 0;
  padding: 0;
  font-family: 'Arial', sans-serif;
  background-color: #000000;
  color: #FFFFFF;
}

header {
  text-align: center;
  padding-top: 50px;
}

h1 {
  color: #FFE500;
}

#buttons {
  position: absolute;
  top: 20px;
  right: 20px;
}

button {
  margin-left: 10px;
  background-color: #B09916;
  color: #000000;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
  border-radius: 5px;
}

#resumeContent {
  display: none;
  max-width: 85%;
  margin: 20px auto;
  padding: 30px;
  background-color: #1F0732;
  color: #FFFFFF;
  border-radius: 30%;
}

#centarContent{
  text-align: center;
  justify-content: center;
  padding-top: 10%;
}



</style>

</html>
