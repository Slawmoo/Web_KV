<?php
session_start(); // Pokretanje sesije za prikazivanje grešaka
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
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
    <?php include 'sidebar.php'; ?>

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

<script>
    
// Funkcija za validaciju forme
function validateForm() {
    // Provjera jačine lozinke
    const password = document.getElementById('pass').value;
    const email = document.getElementById('email').value;
    
    const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$/;
    
    if (!passwordRegex.test(password)) {
        alert('Password must be at least 8 characters long, contain an uppercase letter, a lowercase letter, a number, and a special character.');
        return false;
    }

    // Provjera formata e-maila (HTML input type=email već osigurava osnovnu validaciju, ali možemo dodatno provjeriti)
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert('Please enter a valid email address.');
        return false;
    }

    return true; // Ako sve prođe, vraćamo true kako bi se forma poslala
}



    // Provjerava je li status jednak 'success'
    window.onload = function() {
        if (getQueryParam('status') === 'success') {
            alert("Profile successfully created!");
        }
    };


</script>

<style>
body {
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
    background-color: #000000;
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
    font-weight: 500;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
  }
  
  #button1 {
    background-color: #FFE500;
  }
  
  #button2 {
    background-color: #008D00;
  }
  
  #singUpFormDiv {
    width: 60%;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }
  
  form {
    width: 80%;
    color: #FFE500;
    text-align: center;
    justify-content: center;
  }
  
  label {
    display: block;
    margin-top: 10px;
    padding: 20px;
  }
  
  input,textarea{
    display: block;
    width: 80%;
    margin-bottom: 5px;
    background: #535353;
    margin-left: 9%;
    font-weight: bold;
    font-size: large;
    color: #FFE500;
    font-stretch: extra-expanded;
  }
  
  #email{
    width: 80%;
    margin-left: 9%;
  }
  #description{
    margin-left: 9%;
    resize: none;
  }
  #company{
    width: 80%;
    margin-left: 9%;
    resize: none;
  }
  
  input[type="submit"] {
    margin-top: 50px;
    width: 40%;
    margin-left: 29%;
    background: #008D00;
    border-radius: 12px;
    height: 40px;
  }
  ::placeholder{
    color: #FFE500;
  }
</style>

</html>
