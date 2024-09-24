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