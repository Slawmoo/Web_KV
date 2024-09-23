function showResumeContent(title, contentId) {
    const resumeContent = document.getElementById(contentId);
    const currentContent = resumeContent.innerHTML;

    if (resumeContent.style.display === 'block') {
        resumeContent.style.display = 'none';
    } else {
        // Request the content from the PHP backend
        $.ajax({
            url: 'process_homeContent.php',
            type: 'GET',
            data: { section_title: title },
            success: function(data) {
                resumeContent.innerHTML = `<h2>${title}</h2><p>${data}</p>`;
                resumeContent.style.display = 'block';
            },
            error: function() {
                resumeContent.innerHTML = `<p>Error loading content.</p>`;
                resumeContent.style.display = 'block';
            }
        });

        // Scroll to the newly opened content
        if (currentContent !== '') {
            window.scrollBy(0, resumeContent.offsetHeight + 20);
        }
    }
}
