<?php
// Start the session to access and manage user session data
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Basic HTML metadata for character encoding and responsive viewport -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- External CSS and JS files for styling and functionality -->
    <link rel="stylesheet" href="generalDecor.css">
    <script src="generalScripts.js"></script>
    <title>Sign Out</title>
</head>
<body>
    <!-- Include sidebar navigation from external file -->
    <?php include 'sidebar.php'; ?>

    <!-- Page header with confirmation message -->
    <header>
        <h1>Do you really want to sign out?</h1>
    </header>
    <!-- Menu icon for toggling navigation -->
    <div id="menuIcon">
        <span onclick="toggleNav()">☰ Menu</span>
    </div>
    <!-- Centered content with sign-out form -->
    <div id="centarContent">
        <!-- Form to submit sign-out request to server -->
        <form action="process_signOut.php" method="post">
            <button type="submit" class="sign-out-button">Sign Out</button>
        </form>
    </div>
</body>

<!-- JavaScript for client-side sign-out handling -->
<script>
    // Function to handle sign-out (currently just an alert)
    function signOut() {
        // Display confirmation of sign-out (placeholder logic)
        alert('You have been signed out.');
        // Note: Actual redirection or session clearing should be handled server-side in process_signOut.php
        // Add redirection here if needed, e.g., window.location.href = 'signIn.php';
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
