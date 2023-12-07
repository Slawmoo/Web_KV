// userData.js file

// Function to fetch user data using AJAX
function fetchUserData() {
    $.ajax({
        url: 'ajax_getUserData.php',
        method: 'GET',
        dataType: 'json',
        success: function(userData) {
            // Update the content of the userDataContainer with the fetched user data
            $('#userDataContainer').html(
                '<p>User ID: ' + userData.id + '</p>' +
                '<p>Name: ' + userData.name + '</p>' +
                '<p>Email: ' + userData.email + '</p>' +
                '<p>Description: ' + userData.description + '</p>' +
                '<p>Company: ' + userData.company + '</p>'
            );
        },
        error: function(xhr, status, error) {
            // Handle errors
            console.error('Error fetching user data:', error);
        }
    });
}

// Use jQuery to wait for the document to be ready
$(document).ready(function() {
    // Call the fetchUserData function when the document is ready
    fetchUserData();
});
