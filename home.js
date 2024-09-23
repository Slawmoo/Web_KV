function showResumeContent(imageName, contentId) {
    const resumeContent = document.getElementById(contentId);
    const currentContent = resumeContent.innerHTML;

    // If content is visible, hide it
    if (resumeContent.style.display === 'block') {
        resumeContent.style.display = 'none';
    } else {
        // Modify the content based on the clicked image
        resumeContent.innerHTML = `<h2>${imageName}</h2><h3>THIS IS RESUME CONTENT</h3>`;

        // Show the content
        resumeContent.style.display = 'block';

        // Scroll to the newly opened content
        if (currentContent !== '') {
            window.scrollBy(0, resumeContent.offsetHeight + 20);
        }
    }
}
