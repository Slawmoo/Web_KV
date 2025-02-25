<?php
// Start the session to access user data
session_start();

// Check if the user is logged in by verifying session variables
if (isset($_SESSION['user_name']) && isset($_SESSION['userEmail']) && isset($_SESSION['userCompany']) && isset($_SESSION['userDescription'])) {
    // Assign session data to variables for use in the form
    $user_name = $_SESSION['user_name'];
    $userEmail = $_SESSION['userEmail'];
    $userCompany = $_SESSION['userCompany'];
    $userDescription = $_SESSION['userDescription'];
} else {
    // If user data is missing, display an error and terminate the script
    echo "No user data found.";
    exit;
}
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
    <!-- Include jQuery library for potential future AJAX functionality -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Edit Profile</title>
</head>
<body>
    <!-- Include sidebar navigation from external file -->
    <?php include 'sidebar.php'; ?>
    <!-- Page header with title -->
    <h1>EDIT PROFILE</h1>

    <!-- Menu icon for toggling navigation -->
    <div id="menuIcon">
        <span onclick="toggleNav()">☰ Menu</span>
    </div>

    <!-- Container for the edit profile form -->
    <div id="editUserInfoDiv">
        <!-- Form to update user information, submitted to processEditUser.php -->
        <form id="editUserInfoForm" method="POST" action="processEditUser.php">
            <!-- Form field for user's name, pre-filled with current value -->
            <label for="user_name">Name</label>
            <input type="text" id="user_name" name="user_name" value="<?php echo htmlspecialchars($user_name); ?>" required>
            
            <!-- Form field for user's email, pre-filled with current value -->
            <label for="userEmail">Email</label>
            <input type="email" id="userEmail" name="userEmail" value="<?php echo htmlspecialchars($userEmail); ?>" required>
            
            <!-- Form field for user's company, pre-filled with current value -->
            <label for="userCompany">Company</label>
            <input type="text" id="userCompany" name="userCompany" value="<?php echo htmlspecialchars($userCompany); ?>" required>
            
            <!-- Textarea for user's description, pre-filled with current value -->
            <label for="userDescription">Description</label>
            <textarea id="userDescription" name="userDescription" required><?php echo htmlspecialchars($userDescription); ?></textarea>

            <!-- Group containing save and delete buttons -->
            <div class="button-group">
                <!-- Submit button to save changes -->
                <input type="submit" value="SAVE CHANGES" class="save-btn">
                <!-- Button to trigger account deletion confirmation -->
                <button type="button" class="delete-btn" onclick="confirmDelete();">DELETE ACCAUNT</button>
            </div>
        </form>
    </div>
</body>

<!-- JavaScript for handling account deletion confirmation -->
<script>
    // Function to confirm and handle account deletion
    function confirmDelete() {
        // Prompt user to confirm deletion
        if (confirm('Are you sure you want to delete your account?')) {
            // Redirect to the server-side script to process account deletion
            window.location.href = "process_DeleteUser.php"; // Replace with your actual delete script
        }
    }
</script>
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
    text-align: center;
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
  
  /* Center form and its elements */
#editUserInfoForm {
  width: 60%;
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  align-items: center;
}

/* Style individual form elements */
input, textarea {
  display: block;
  width: 50%;
  margin-bottom: 5px;
  background: #535353;
  color: #fff;
  min-width: 150px;
  max-width: 250px;
}

/* Ensure form buttons are aligned properly */
.button-group {
  display: flex;
  justify-content: flex-start; /* Align buttons to the left */
  align-items: center; /* Align buttons vertically */
  gap: 6px; /* Space between buttons */
   
}

/* Ensure buttons are the same height and have proper vertical alignment */
button, input[type="submit"] {
  margin-top: 25px;
  height: 50px;
  border-radius: 12px;
  font-weight: bold;
  max-width: 150px;
  display: flex;
  justify-content: center;
  align-items: center;
  vertical-align: middle; /* Align buttons on the same axis */
}
/* Ensure buttons are the same height and have proper vertical alignment */
button{
  margin-top: 20px;
  height: 50px;
  border-radius: 12px;
  font-weight: bold;
  max-width: 150px;
  display: flex;
  justify-content: center;
  align-items: center;
  vertical-align: middle; /* Align buttons on the same axis */
}
/* Save button styling */
.save-btn {
  background-color: #008D00;
  color: #FFE500;
  border: none;
  cursor: pointer;
}

/* Delete button styling */
.delete-btn {
  background-color: red;
  color: #000000;
  border: none;
  cursor: pointer;
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
  
  input, textarea {
    display: block;
    width: 50%;
    margin-bottom: 5px;
    background: #535353;
    color: #fff;
    min-width: 150px;
    max-width: 250px;
  }
  
  textarea {
    height: 100px;
  }
</style>
</html>
