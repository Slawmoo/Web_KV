<?php
session_start();
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest';

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
$sections = [];
$sql = "SELECT section_title, section_content FROM home_content";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sections[] = $row;  // Store each section as an associative array
    }
} else {
    echo "<p style='text-align: center;'>No sections found.</p>";
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
        <h1 id="mainTitle">Home and M. K.</h1>
        <span id="welcome-text">Welcome <?php echo htmlspecialchars($user_name); ?>!</span>
    </header>

    <div id="menuIcon">
        <span onclick="toggleNav()">&#9776; Menu</span>
    </div>

    <div id="CV_list">
        <?php foreach ($sections as $index => $section): ?>
            <div class="cvSection" onclick="showResumeContent('<?php echo htmlspecialchars($section['section_title']); ?>', 'resumeContent<?php echo $index; ?>')">
                <div class="sectionText"><?php echo htmlspecialchars($section['section_title']); ?></div>
            </div>
            <div id="resumeContent<?php echo $index; ?>" class="resumeContent">
                <h3>Content for <?php echo htmlspecialchars($section['section_title']); ?></h3>
                <p><?php echo htmlspecialchars($section['section_content']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
