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
    <link rel="stylesheet" href="generalDecor.css">
    <script src="generalScripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Edit Profile</title>
</head>
<body>
<?php include 'sidebar.php'; ?>
<h1>EDIT PROFILE</h1>

<div id="menuIcon">
        <span onclick="toggleNav()">&#9776; Menu</span>
    </div>

    <div id="editUserInfoDiv">
    <form id="editUserInfoForm" method="POST" action="processEditUser.php">
        <!-- Form fields for name, email, company, and description -->
        <label for="user_name">Name</label>
        <input type="text" id="user_name" name="user_name" value="<?php echo $user_name; ?>" required>
        
        <label for="userEmail">Email</label>
        <input type="email" id="userEmail" name="userEmail" value="<?php echo $userEmail; ?>" required>
        
        <label for="userCompany">Company</label>
        <input type="text" id="userCompany" name="userCompany" value="<?php echo $userCompany; ?>" required>
        
        <label for="userDescription">Description</label>
        <textarea id="userDescription" name="userDescription" required><?php echo $userDescription; ?></textarea>

        <!-- Wrap both buttons in the same button group -->
        <div class="button-group">
            <input type="submit" value="SAVE CHANGES" class="save-btn">
            <button type="button" class="delete-btn" onclick="confirmDelete();">DELETE ACCAUNT</button>
        </div>
    </form>
</div>

</body>
<script>
function confirmDelete() {
    if (confirm('Are you sure you want to delete your account?')) {
        // Redirect to the delete process or form submission
        window.location.href = "process_DeleteUser.php"; // Replace with your actual delete script
    }
}
</script>

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
