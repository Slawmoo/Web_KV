function showResumeContent(index) {
    const allSections = document.querySelectorAll('.cvSection');
    const content = document.getElementById('resumeContent' + index);

    allSections.forEach((section, idx) => {
        const contentElement = document.getElementById('resumeContent' + idx);
        
        if (idx === index) {
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
