<?php
session_start();
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest';
$isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] != 0; // Check if the user is an admin

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_data";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch CV sections
$sql = "SELECT section_title, section_content FROM home_content";
$result = $conn->query($sql);

$sections_titles = [];
$sections_contents = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sections_titles[] = $row['section_title'];
        $sections_contents[] = $row['section_content'];
    }
} else {
    echo "No sections found";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="generalDecor.css">
    <script src="generalScripts.js"></script>
    <script src="home.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>HOME</title>
</head>

<body>
    <?php include 'sidebar.php'; ?>

    <header>
        <h1 id="mainTitle">Marko's Journey</h1>
        <span id="welcome-text">Welcome <?php echo htmlspecialchars($user_name); ?>!</span>
    </header>

    <div id="menuIcon">
        <span onclick="toggleNav()">&#9776; Menu</span>
    </div>

    <div id="CV_list">
        <?php foreach ($sections_titles as $index => $sectionTitle): ?>
            <div class="cvSection" onclick="showResumeContent(<?php echo $index; ?>)">
                <div class="sectionText"><?php echo htmlspecialchars($sectionTitle); ?></div>
                <div id="resumeContent<?php echo $index; ?>" class="resumeContent">
                    <p><?php echo htmlspecialchars($sections_contents[$index]); ?></p>
                </div>
            </div>

            <!-- Admin buttons -->
            <?php if ($isAdmin): ?>
                <div class="admin-buttons">
                    <button onclick="editContent(<?php echo $index; ?>)">Edit Content</button>
                    <button style="display:none;" id="saveButton<?php echo $index; ?>" onclick="saveContent(<?php echo $index; ?>)">Save Changes</button>
                    <button style="display:none;" id="cancelButton<?php echo $index; ?>" onclick="cancelEdit(<?php echo $index; ?>)">Cancel Edit</button>
                </div>

                <!-- Editable fields (initially hidden) -->
                <div class="editFields" id="editFields<?php echo $index; ?>" style="display:none;">
                    <input type="text" id="editTitle<?php echo $index; ?>" value="<?php echo htmlspecialchars($sectionTitle); ?>" />
                    <br>
                    <textarea id="editContent<?php echo $index; ?>"><?php echo htmlspecialchars($sections_contents[$index]); ?></textarea>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

        <!-- Add Section button -->
        <?php if ($isAdmin): ?>
            <div class="add-section-button">
                <button>Add Section +</button>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function editContent(index) {
            // Show input fields for editing
            document.getElementById('editFields' + index).style.display = 'block';
            document.getElementById('saveButton' + index).style.display = 'inline-block';
            document.getElementById('cancelButton' + index).style.display = 'inline-block';
        }

        function saveContent(index) {
            const title = document.getElementById('editTitle' + index).value;
            const content = document.getElementById('editContent' + index).value;

            // Make an AJAX request to update the content
            $.ajax({
                url: 'process_homeContent.php',
                type: 'POST',
                data: {
                    section_title: title,
                    section_content: content
                },
                success: function(response) {
                    // Hide the edit fields and buttons
                    document.getElementById('editFields' + index).style.display = 'none';
                    document.getElementById('saveButton' + index).style.display = 'none';
                    document.getElementById('cancelButton' + index).style.display = 'none';

                    // Optionally, update the displayed section title and content
                    document.querySelectorAll('.cvSection .sectionText')[index].textContent = title;
                    document.getElementById('resumeContent' + index).querySelector('p').textContent = content;
                },
                error: function() {
                    alert('Error updating content.');
                }
            });
        }

        function cancelEdit(index) {
            // Hide the edit fields and buttons
            document.getElementById('editFields' + index).style.display = 'none';
            document.getElementById('saveButton' + index).style.display = 'none';
            document.getElementById('cancelButton' + index).style.display = 'none';
        }
    </script>
</body>
</html>
