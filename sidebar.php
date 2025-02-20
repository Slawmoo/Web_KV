<div id="sidebar">
    <a href="home.php">Home</a>
    <a href="sendMsg.php">Send Message</a>
    <a href="signUp.php">Sign Up</a>
    <a href="signIn.php">Sign In</a>
    <a href="signOut.php">Sign Out</a>
    <a href="#" onclick="closeNav()">Close Menu</a>

    <!-- User Info Section -->
    <div id="userInfo">
        <div>PROFILE</div><br>
        <?php if (isset($_SESSION['user_name']) && isset($_SESSION['userEmail']) && isset($_SESSION['userCompany']) && isset($_SESSION['userDescription'])): ?>
            <div id="user_name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></div>
            <div id="userEmail"><?php echo htmlspecialchars($_SESSION['userEmail']); ?></div>
            <div id="userCompany"><?php echo htmlspecialchars($_SESSION['userCompany']); ?></div>
            <div id="userDescription" onclick="toggleDescription()">
                <span id="shortDescription"><?php echo htmlspecialchars(substr($_SESSION['userDescription'], 0, 20)) . (strlen($_SESSION['userDescription']) > 20 ? '...' : ''); ?></span>
                <span id="fullDescription"><?php echo htmlspecialchars($_SESSION['userDescription']); ?></span>
            </div>
            <button id="editInfoBtn" onclick="redirectToEditPage()">Edit Info</button>
        <?php else: ?>
            <div>Sign in to see information</div>
        <?php endif; ?>
    </div>
</div>
<script>
    function redirectToEditPage() {
    window.location.href = "editUserInfo.php";   
  }
</script>
