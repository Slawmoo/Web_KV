<!-- Sidebar navigation menu -->
<div id="sidebar">
    <!-- Links to different pages -->
    <a href="home.php">Home</a>
    <a href="sendMsg.php">Send Message</a>
    <a href="signUp.php">Sign Up</a>
    <a href="signIn.php">Sign In</a>
    <a href="signOut.php">Sign Out</a>
    <!-- Link to close the sidebar -->
    <a href="#" onclick="closeNav()">Close Menu</a>

    <!-- User information section -->
    <div id="userInfo">
        <div>PROFILE</div><br>
        <?php 
        // Check if user session data is set to display profile info
        if (isset($_SESSION['user_name']) && isset($_SESSION['userEmail']) && isset($_SESSION['userCompany']) && isset($_SESSION['userDescription'])): ?>
            <!-- Display user's name -->
            <div id="user_name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></div>
            <!-- Display user's email -->
            <div id="userEmail"><?php echo htmlspecialchars($_SESSION['userEmail']); ?></div>
            <!-- Display user's company -->
            <div id="userCompany"><?php echo htmlspecialchars($_SESSION['userCompany']); ?></div>
            <!-- Display user's description with toggle functionality -->
            <div id="userDescription" onclick="toggleDescription()">
                <!-- Shortened description (first 20 characters), with ellipsis if longer -->
                <span id="shortDescription"><?php echo htmlspecialchars(substr($_SESSION['userDescription'], 0, 20)) . (strlen($_SESSION['userDescription']) > 20 ? '...' : ''); ?></span>
                <!-- Full description, toggled via JavaScript -->
                <span id="fullDescription"><?php echo htmlspecialchars($_SESSION['userDescription']); ?></span>
            </div>
            <!-- Button to redirect to edit page -->
            <button id="editInfoBtn" onclick="redirectToEditPage()">Edit Info</button>
        <?php else: ?>
            <!-- Message shown if user is not signed in -->
            <div>Sign in to see information</div>
        <?php endif; ?>
    </div>
</div>

<!-- JavaScript for sidebar functionality -->
<script>
    // Function to redirect user to the edit info page
    function redirectToEditPage() {
        window.location.href = "editUserInfo.php";   
    }
</script>