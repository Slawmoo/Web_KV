function toggleNav() {
    const sidebar = document.getElementById("sidebar");
    const sidebarWidth = sidebar.offsetWidth;
    if (sidebarWidth === 0) {
        sidebar.style.width = "250px";
    } else {
        sidebar.style.width = "0";
    }
}

function closeNav() {
    document.getElementById("sidebar").style.width = "0";
}

function toggleDescription() {
    const description = document.getElementById('userDescription');
    description.classList.toggle('expanded');
}

