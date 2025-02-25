<?php
// Start the session to manage user data across pages
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
    <script src="sendMsg.js"></script>
    <title>Send Message</title>
</head>
<body>
    <!-- Include sidebar navigation from external file -->
    <?php include 'sidebar.php'; ?>

    <!-- Page header with title -->
    <header>
        <h1>Send Query To Owner</h1>
    </header>
    <!-- Menu icon for toggling navigation -->
    <div id="menuIcon">
        <span onclick="toggleNav()">☰ Menu</span>
    </div>

    <!-- Section for sending a message -->
    <div id="sendMessage">
        <!-- Form for submitting a message -->
        <form id="sendMessageForm">
            <label for="description">Email content:</label>
            <!-- Textarea for user to input message, limited to 200 characters -->
            <textarea id="description" name="description" rows="10" maxlength="200" placeholder="Enter message for owner" required></textarea>            
            <input type="submit" value="Send">
        </form>
        <!-- Div to display feedback messages after submission -->
        <div id="messageStatus"></div>
    </div>

    <!-- JavaScript for handling form submission -->
    <script>
        // Add event listener to handle form submission with AJAX
        document.getElementById('sendMessageForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Get the message content from the textarea
            const description = document.getElementById('description').value;

            // Send the message to the server using fetch API
            fetch('process_sendMsg.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json', // Set content type to JSON
                },
                body: JSON.stringify({ description: description }) // Convert data to JSON string
            })
            .then(response => response.json()) // Parse JSON response from server
            .then(data => {
                // Get the div where status messages will be displayed
                const messageStatus = document.getElementById('messageStatus');
                messageStatus.innerHTML = ''; // Clear any previous messages

                // Display success or error message based on server response
                if (data.success) {
                    messageStatus.innerHTML = `<p class="success">${data.message}</p>`;
                } else {
                    messageStatus.innerHTML = `<p class="error">${data.message}</p>`;
                }
            })
            .catch(error => {
                // Handle any errors during the fetch request
                document.getElementById('messageStatus').innerHTML = `<p class="error">There was an error sending your message. Please try again later.</p>`;
            });
        });
    </script>
</body>
</html>
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
  
  #button1 {
    background-color: #FFE500;
  }
  
  #button2 {
    background-color: #008D00;
  }
  
  #sendMessage {
    width: 70%;
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
  
  #description{
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
