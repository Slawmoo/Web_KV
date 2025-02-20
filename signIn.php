<?php
session_start();
?>
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

<body>
    <?php include 'sidebar.php'; ?>
    <header>
        <h1>SIGN IN</h1>
    </header>
    <div id="menuIcon">
        <span onclick="toggleNav()">&#9776; Menu</span>
    </div>
    
    <div id="singInFormDiv">
        <div id="error-message" style="color: #ff4444; text-align: center; margin: 10px 0; display: none;"></div>
        <form id="signInForm" method="post">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password</label>
            <input type="password" id="pass" name="password" required>
            <input type="submit" value="SIGN IN">
        </form> 
    </div>
</body>

<script>
function getQueryParam(param) {
    let urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}

window.onload = function() {
    if (getQueryParam('status') === 'success') {
        alert("Profile successfully created!");
    }
};

$(document).ready(function() {
    $('#signInForm').on('submit', function(e) {
        e.preventDefault();

        console.log('Form submitted');  // Debugging flag
        
        $.ajax({
            type: 'POST',
            url: 'process_signIn.php',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                console.log('Response received', response);  // Debugging flag
                if (response.success) {
                    window.location.href = 'home.php';
                } else {
                    $('#error-message')
                        .text(response.message)
                        .show()
                        .css({
                            'background-color': 'rgba(255, 68, 68, 0.1)',
                            'padding': '10px',
                            'border-radius': '4px',
                            'margin-bottom': '20px'
                        });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error occurred: ', textStatus, errorThrown);  // Debugging flag
                $('#error-message')
                    .text('An error occurred. Please try again.')
                    .show();
            }
        });
    });
});
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

input {
    display: block;
    width: 50%;
    margin-bottom: 5px;
    background: #535353;
    min-width: 150px;
    max-width: 250px;
    padding: 8px;
    border: 1px solid #666;
    border-radius: 4px;
    color: #FFE500;
}

input[type="submit"] {
    margin-top: 50px;
    width: 30%;
    background: #008D00;
    border-radius: 12px;
    height: 40px;
    max-width: 150px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    background: #006B00;
}

@media (max-width: 768px) {
    #signInForm {
        width: 90%;
    }
    
    input {
        width: 80%;
        max-width: none;
    }
}
</style>
</html>