document.addEventListener("DOMContentLoaded", function(event) {

    const showNavbar = (navId, bodyId, headerId) => {
        const nav = document.getElementById(navId),
            bodypd = document.getElementById(bodyId),
            headerpd = document.getElementById(headerId);

        // Validate that all variables exist
        if (nav && bodypd && headerpd) {
            // Show navbar
            nav.classList.add('show');

            // Add padding to body and header
            bodypd.classList.add('body-pd');
            headerpd.classList.add('body-pd');
        }
    }

    // Automatically show the navbar without toggle
    showNavbar('nav-bar', 'body-pd', 'header');

    /*===== LINK ACTIVE =====*/
    const linkColor = document.querySelectorAll('.nav_link')

    function colorLink() {
        if (linkColor) {
            linkColor.forEach(l => l.classList.remove('active'))
            this.classList.add('active')
        }
    }
    linkColor.forEach(l => l.addEventListener('click', colorLink))

    // Your code to run since DOM is loaded and ready
});
