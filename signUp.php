<?php
// Start the session to manage and display errors across pages
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
    <script src="signUp.js"></script>
    <title>Sign Up</title>
    <!-- Inline CSS for error message styling -->
    <style>
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <!-- Include sidebar navigation from external file -->
    <?php include 'sidebar.php'; ?>

    <!-- Page header with title -->
    <header>
        <h1>REGISTER</h1>
    </header>
    
    <!-- Menu icon for toggling navigation -->
    <div id="menuIcon">
        <span onclick="toggleNav()">☰ Menu</span>
    </div>

    <!-- Container for the sign-up form -->
    <div id="singUpFormDiv">
        <!-- Form for user registration, submitted to process_signUp.php -->
        <form id="signupForm" action="process_signUp.php" method="POST" onsubmit="return validateForm()">
            <!-- Display error message from session if it exists -->
            <?php
            if (isset($_SESSION['error'])) {
                echo "<p class='error'>" . $_SESSION['error'] . "</p>";
                unset($_SESSION['error']); // Clear the error after displaying it
            }
            ?>

            <!-- Input field for user's name -->
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" maxlength="50" required>

            <!-- Input field for user's email -->
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" placeholder="Enter e-mail" required>

            <!-- Input field for user's password -->
            <label for="password">Password</label>
            <input type="password" id="pass" name="password" placeholder="Enter password" required>

            <!-- Textarea for user's short description -->
            <label for="description">Short description</label>
            <textarea id="description" name="description" rows="5" maxlength="200" placeholder="Describe yourself or company" required></textarea>            

            <!-- Input field for user's company name -->
            <label for="company">Company Name</label>
            <input type="text" id="company" name="company" maxlength="100" placeholder="Name of Your company" required>

            <!-- Submit button to create profile -->
            <input type="submit" value="Make Profile">
        </form>
    </div>

    <!-- JavaScript for form validation and page load behavior -->
    <script>
    // Function to retrieve query parameters from the URL
    function getQueryParam(param) {
        let urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    // Function to validate the sign-up form before submission
    function validateForm() {
        // Get form field values
        const password = document.getElementById('pass').value;
        const email = document.getElementById('email').value;
        
        // Regex for strong password: min 8 chars, uppercase, lowercase, number, special char
        const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$/;
        if (!passwordRegex.test(password)) {
            alert('Password must be at least 8 characters long, contain an uppercase letter, a lowercase letter, a number, and a special character.');
            return false; // Prevent form submission
        }

        // Regex for email validation (additional check beyond HTML5 type="email")
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('Please enter a valid email address.');
            return false; // Prevent form submission
        }

        return true; // Allow form submission if all validations pass
    }

    // Check for success status on page load
    window.onload = function() {
        // Show alert if profile creation was successful (from query parameter)
        if (getQueryParam('status') === 'success') {
            alert("Profile successfully created!");
        }
    };
    </script>
</body>
</html>

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
