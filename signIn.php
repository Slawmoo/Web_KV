<?php
session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="generalDecor.css">
    <script src="generalScripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Sign In</title>
    
</head>
<script>
     
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

<script>

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


#signInForm {
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

input{
  display: block;
  width: 50%;
  margin-bottom: 5px;
  background: #535353;
  min-width: 150px;
  max-width: 250px;
}

input[type="submit"] {
  margin-top: 50px;
  width: 30%;
  background: #008D00;
  border-radius: 12px;
  height: 40px;
  max-width: 150px;
  font-weight: bold;
}
</style>

</html>
