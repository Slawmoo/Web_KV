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
