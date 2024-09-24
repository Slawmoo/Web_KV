
<?php
session_start();
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest';
$isAdmin = $_SESSION['isAdmin'] != 0; // Fetch isAdmin from session

// Povezivanje s bazom podataka
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_data";

// Kreiranje veze
$conn = new mysqli($servername, $username, $password, $dbname);

// Provjera veze
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch CV sections
$sql = "SELECT id, section_title, section_content FROM home_content";
$result = $conn->query($sql);

$sections = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sections[] = $row; // Store each section as an array
    }
} else {
    echo "No sections found";
}

// Zatvaranje veze
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
    <?php foreach ($sections as $section): ?>
        <div class="cvSection" onclick="showResumeContent(<?php echo $section['id']; ?>)">
            <div class="sectionText"><?php echo htmlspecialchars($section['section_title']); ?></div>
            <div id="resumeContent<?php echo $section['id']; ?>" class="resumeContent">
                <p><?php echo htmlspecialchars($section['section_content']); ?></p>
            </div>
        </div>

        <!-- Admin buttons -->
        <?php if ($isAdmin): ?>
            <div class="admin-buttons">
                <button onclick="editContent(<?php echo $section['id']; ?>)">Edit Content</button>
                <button style="display:none;" id="saveButton<?php echo $section['id']; ?>" onclick="saveContent(<?php echo $section['id']; ?>)">Save Changes</button>
                <button style="display:none;" id="cancelButton<?php echo $section['id']; ?>" onclick="cancelEdit(<?php echo $section['id']; ?>)">Cancel Edit</button>
            </div>

            <!-- Editable fields (initially hidden) -->
            <div class="editFields" id="editFields<?php echo $section['id']; ?>" style="display:none;">
                <input type="text" id="editTitle<?php echo $section['id']; ?>" value="<?php echo htmlspecialchars($section['section_title']); ?>" />
                <textarea id="editContent<?php echo $section['id']; ?>"><?php echo htmlspecialchars($section['section_content']); ?></textarea>
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
