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
        <h1>Send Query To Owner</h1>
    </header>
    <div id="menuIcon">
        <span onclick="toggleNav()">&#9776; Menu</span>
    </div>

    <div id="sendMessage">
        <form id="sendMessageForm">
            <label for="description">Email content:</label>
            <textarea id="description" name="description" rows="10" maxlength="200" placeholder="Enter message for owner" required></textarea>            
            <input type="submit" value="Send">
        </form>
        <!-- Div za prikaz povratnih poruka -->
        <div id="messageStatus"></div>
    </div>

    <script>
        // Obrada forme putem AJAX-a
        document.getElementById('sendMessageForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const description = document.getElementById('description').value;

            fetch('process_sendMsg.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ description: description })
            })
            .then(response => response.json())
            .then(data => {
                const messageStatus = document.getElementById('messageStatus');
                messageStatus.innerHTML = ''; // Resetiraj prethodne poruke

                if (data.success) {
                    messageStatus.innerHTML = `<p class="success">${data.message}</p>`;
                } else {
                    messageStatus.innerHTML = `<p class="error">${data.message}</p>`;
                }
            })
            .catch(error => {
                document.getElementById('messageStatus').innerHTML = `<p class="error">There was an error sending your message. Please try again later.</p>`;
            });
        });
    </script>
</body>
</html>
