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
    <link rel="stylesheet" href="generalDecor.css">
    <script src="generalScripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLJqZBP_SJe1R-8aLmhqu7PMZiKH_UB3w&callback=initMap" async defer></script>

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
                <br><br>
                <textarea id="editContent<?php echo $section['id']; ?>"><?php echo htmlspecialchars($section['section_content']); ?></textarea>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <!-- Add Section button -->
    <?php if ($isAdmin): ?>
        <div class="add-section-button">
            <button onclick="showAddSectionForm()">Add Section +</button>
        </div>

        <!-- Add Section Form (Initially hidden) -->
        <div class="editFields" id="addSectionForm" style="display:none;">
            <input type="text" id="newSectionTitle" placeholder="Enter new section title" />
            <br><br>
            <textarea id="newSectionContent" placeholder="Enter new section content"></textarea>
            <br>
            <button onclick="addNewSection()">Add New Section</button>
            <button onclick="cancelAddSection()">Cancel</button>
        </div>
    <?php endif; ?>
</div>
    <div id="map" style="height: 400px; width: 100%;"></div>
    <script>
        function initMap() {
            const osijek = { lat: 45.5515, lng: 18.7055 };
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: osijek,
            });

            const marker = new google.maps.Marker({
                position: osijek,
                map: map,
                title: "Osijek"
            });
        }
    </script>
</body>

<script>
    function showResumeContent(id) {
    const allSections = document.querySelectorAll('.cvSection');

    allSections.forEach((section) => {
        const contentElement = section.querySelector('.resumeContent');

        // Check if the current section matches the clicked one
        if (section.contains(document.getElementById('resumeContent' + id))) {
            // Toggle display for clicked section
            if (contentElement.style.display === 'block') {
                contentElement.style.display = 'none';
                section.classList.remove('active');
            } else {
                contentElement.style.display = 'block';
                section.classList.add('active');
            }
        } else {
            // Hide others
            contentElement.style.display = 'none';
            section.classList.remove('active');
        }
    });
}

function editContent(index) {
    // Show input fields for editing
    document.getElementById('editFields' + index).style.display = 'block';
    document.getElementById('saveButton' + index).style.display = 'inline-block';
    document.getElementById('cancelButton' + index).style.display = 'inline-block';
}
function cancelEdit(index) {
    // Hide the edit fields and buttons
    document.getElementById('editFields' + index).style.display = 'none';
    document.getElementById('saveButton' + index).style.display = 'none';
    document.getElementById('cancelButton' + index).style.display = 'none';
}
function saveContent(id) {
    const title = document.getElementById('editTitle' + id).value;
    const content = document.getElementById('editContent' + id).value;

    // Make an AJAX request to update the content using id
    $.ajax({
        url: 'process_homeContent.php',
        type: 'POST',
        data: {
            id: id,
            section_title: title,
            section_content: content
        },
        success: function(response) {
            // Hide the edit fields and buttons
            document.getElementById('editFields' + id).style.display = 'none';
            document.getElementById('saveButton' + id).style.display = 'none';
            document.getElementById('cancelButton' + id).style.display = 'none';

            // Optionally, update the displayed section title and content
            document.querySelectorAll('.cvSection .sectionText')[id].textContent = title;
            document.getElementById('resumeContent' + id).querySelector('p').textContent = content;
        },
        error: function() {
            alert('Error updating content.');
        }
    });
}
//NEW SECTION
function showAddSectionForm() {
    document.getElementById('addSectionForm').style.display = 'block';
}

function cancelAddSection() {
    document.getElementById('addSectionForm').style.display = 'none';
}

function addNewSection() {
    const newTitle = document.getElementById('newSectionTitle').value;
    const newContent = document.getElementById('newSectionContent').value;

    // Check if the fields are not empty
    if (!newTitle || !newContent) {
        alert("Please fill in both the title and content.");
        return;
    }

    // AJAX request to send new section data to the server
    $.ajax({
        url: 'process_addSection.php',  // This PHP file will handle inserting the new section into the database
        type: 'POST',
        data: {
            section_title: newTitle,
            section_content: newContent
        },
        success: function(response) {
            // Assuming the response contains the new section's ID
            const newSectionId = response.new_id;

            // Add the new section dynamically to the page
            const newSectionHtml = `
                <div class="cvSection" onclick="showResumeContent(${newSectionId})">
                    <div class="sectionText">${newTitle}</div>
                    <div id="resumeContent${newSectionId}" class="resumeContent">
                        <p>${newContent}</p>
                    </div>
                </div>
            `;
            
            // Append the new section to the CV list
            document.getElementById('CV_list').innerHTML += newSectionHtml;

            // Hide the add section form and reset the fields
            document.getElementById('addSectionForm').style.display = 'none';
            document.getElementById('newSectionTitle').value = '';
            document.getElementById('newSectionContent').value = '';
        },
        error: function() {
            alert('Error adding new section.');
        }
    });
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

#welcome-text {
  float: right;
  font-size: 23px;
  color: #FFE500;
  margin-right: 20px;
}

#CV_list {
  display: flex;
  flex-direction: column;
  align-items: center; /* Centriranje sekcija */
  padding: 20px;
}

.cvSection {
  width: 80%; /* Širina panela */
  height: auto; /* Automatska visina prema sadržaju */
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #800080; /* Ljubičasta boja panela */
  margin-bottom: 15px; /* Razmak između panela */
  padding: 20px; /* Unutarnji razmak za bolji izgled teksta */
  border-radius: 10px; /* Blagi zaobljeni rubovi */
  color: #FFE500; /* Boja teksta */
  font-size: 24px;
  font-weight: bold;
  text-align: center;
  transition: background-color 0.3s, opacity 0.3s, height 0.5s ease; /* Dodan prijelaz za visinu */
  cursor: pointer;
}

.cvSection:hover {
  opacity: 0.8; /* Efekt na hover */
  background-color: #370c4e; /* Tamnija ljubičasta na hover */
}

.sectionText {
  color: #FFE500;
  font-size: 24px;
  font-weight: bold;
  text-align: center;
}

.resumeContent {
  display: none;
  max-width: 85%;
  margin: 20px auto;
  padding: 30px;
  background-color: #1F0732;
  color: #FFFFFF;
  border-radius: 10px;
  overflow: hidden;
  max-height: 0; /* Početno skriveno */
  transition: max-height 0.5s ease-out, padding 0.5s ease-out; /* Animacija za prikaz sadržaja */
}

.cvSection.active .resumeContent {
  display: block;
  max-height: 500px; /* Dovoljno da prikaže sadržaj */
  padding: 20px; /* Povećanje paddinga pri otvaranju */
  animation: slideDown 0.5s ease-out forwards;
}

@keyframes slideDown {
  0% {
    opacity: 0;
    transform: translateY(-20px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}
.admin-buttons {
  display: flex;
  justify-content: space-around; /* Distribute buttons evenly */
  margin-top: 10px; /* Add some space above the buttons */
  margin-bottom: 25px;
}

.add-section-button {
  text-align: center; /* Center the Add Section button */
  margin-top: 20px; /* Add space above the button */
}

/*EDIT BUTTONS*/
.editFields {
  display: flex;
  flex-direction: column;
  align-items: center; /* Center elements horizontally */
  margin-bottom: 5px; /* Space below the entire edit section */
  text-align: center;
  border-radius: 5px;
}

.editFields input[type="text"] {
  width: 50%; /* Make the title input take 50% of the screen width */
  padding: 12px; /* Add padding inside the input */
  background-color: #535353; /* Set background color */
  color: #FFE500; /* Set text color */
  text-align: center; /* Center the text inside the input */
  border: none; /* Remove border */
  margin-bottom: 20px; /* Space between input and textarea */
  font-size: 18px; /* Increase font size */
  border-radius: 5px;
}

.editFields textarea {
  width: 80%; /* Make the textarea take 80% of the screen width */
  height: 200px; /* Increase the height of the textarea */
  padding: 14px; /* Add padding inside the textarea */
  background-color: #535353; /* Set background color */
  color: #FFE500; /* Set text color */
  font-size: 16px; /* Increase font size */
  margin-bottom: 20px; /* Space below the textarea */
  border-radius: 5px;
}
/*ADD NEW SECTIONS*/
#addSectionForm {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 20px;
}

#newSectionTitle, #newSectionContent {
  background-color: #535353;
  color: #FFE500;
  padding: 10px;
  border: none;
  font-size: 16px;
  margin-bottom: 20px;
}

#newSectionTitle {
  width: 50%;
  text-align: center;
}

#newSectionContent {
  width: 80%;
  height: 200px;
  resize: none;
}
@media only screen and (max-width: 768px) {
  body {
      font-size: 16px; /* Manji font za mobilne uređaje */
  }

  header {
      padding-top: 20px; /* Manje razmakivanje na vrhu */
  }

  #welcome-text {
      font-size: 18px; /* Manji tekst dobrodošlice */
      margin-right: 10px; /* Manji razmak */
  }

  #CV_list {
      padding: 10px; /* Manje paddinga */
  }

  .cvSection {
      width: 90%; /* Širina panela za mobilne uređaje */
      font-size: 20px; /* Manji font za mobilne uređaje */
      padding: 15px; /* Manji padding */
  }

  .sectionText {
      font-size: 20px; /* Manji font za naziv sekcije */
  }

  .editFields input[type="text"],
  .editFields textarea,
  #newSectionTitle,
  #newSectionContent {
      width: 90%; /* Širina za mobilne uređaje */
  }
  button {
    padding: 15px 25px; /* Povećan padding za veća dugmad */
    font-size: 18px; /* Veći font za lakše čitanje */
}

}
</style>

</html>