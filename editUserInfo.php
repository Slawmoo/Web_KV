<?php
session_start();

// Provjera je li korisnik prijavljen
if (isset($_SESSION['user_name']) && isset($_SESSION['userEmail']) && isset($_SESSION['userCompany']) && isset($_SESSION['userDescription'])) {
    $user_name = $_SESSION['user_name'];
    $userEmail = $_SESSION['userEmail'];
    $userCompany = $_SESSION['userCompany'];
    $userDescription = $_SESSION['userDescription'];
} else {
    echo "No user data found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="editUserInfo.css">
    <title>Edit Profile</title>
</head>
<body>
<h1>EDIT PROFILE</h1>
<div id="editUserInfoDiv">
    <form id="editUserInfoForm" method="POST" action="processEditUser.php">
        <label for="user_name">Name</label>
        <input type="text" id="user_name" name="user_name" value="<?php echo $user_name; ?>" required>
        
        <label for="userEmail">Email</label>
        <input type="email" id="userEmail" name="userEmail" value="<?php echo $userEmail; ?>" required>
        
        <label for="userCompany">Company</label>
        <input type="text" id="userCompany" name="userCompany" value="<?php echo $userCompany; ?>" required>
        
        <label for="userDescription">Description</label>
        <textarea id="userDescription" name="userDescription" required><?php echo $userDescription; ?></textarea>
        
        <input type="submit" value="SAVE CHANGES">
    </form>
</div>

</body>
</html>
