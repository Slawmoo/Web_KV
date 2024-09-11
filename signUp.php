<?php
session_start(); // Pokretanje sesije za prikazivanje grešaka
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signUp.css">
    <link rel="stylesheet" href="generalDecor.css">
    <script src="generalScripts.js"></script>
    <script src="signUp.js"></script>
    <title>Sign Up</title>
    <style>
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <!-- Add To Sidebar -->
    <div id="sidebar">
        <a href="home.html">Home</a>
        <a href="sendMsg.html">Send Message</a>
        <a href="signUp.php">Sign Up</a>
        <a href="signIn.html">Sign In</a>
        <a href="signOut.html">Sign Out</a>
        <a href="FAQ.html">FAQ</a>
        <a href="#" onclick="closeNav()">Close Menu</a>
    </div>

    <header>
        <h1>REGISTER</h1>
    </header>
    
    <div id="menuIcon">
        <span onclick="toggleNav()">&#9776; Menu</span>
    </div>

    <div id="singUpFormDiv">
        <form id="signupForm" action="process_signUp.php" method="POST" onsubmit="return validateForm()">
            <!-- Prikaz greške ako postoji -->
            <?php
            if (isset($_SESSION['error'])) {
                echo "<p class='error'>" . $_SESSION['error'] . "</p>";
                unset($_SESSION['error']); // Brišemo grešku nakon prikaza
            }
            ?>

            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" maxlength="50" required>

            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" placeholder="Enter e-mail" required>

            <label for="password">Password</label>
            <input type="password" id="pass" name="password" placeholder="Enter password" required>

            <label for="description">Short description</label>
            <textarea id="description" name="description" rows="5" maxlength="200" placeholder="Describe yourself or company" required></textarea>            

            <label for="company">Company Name</label>
            <input type="text" id="company" name="company" maxlength="100" placeholder="Name of Your company" required>

            <input type="submit" value="Make Profile">
        </form>
    </div>

    <!-- JavaScript za validaciju forme -->
    <script>
    function validateForm() {
        // Provjera lozinke
        const password = document.getElementById('pass').value;
        const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$/;

        if (!passwordRegex.test(password)) {
            alert('Password must be at least 8 characters long, contain an uppercase letter, a lowercase letter, a number, and a special character.');
            return false;
        }

        // Provjera e-mail formata (HTML5 input već obavlja osnovnu provjeru)
        return true;
    }
    </script>
</body>
</html>
