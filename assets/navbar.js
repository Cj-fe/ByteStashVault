
document.addEventListener("DOMContentLoaded", function() {
    // Select elements
    const mobileSearchIcon = document.querySelector(".mobile-search-icon");
    const searchOverlay = document.querySelector(".search-overlay");
    const searchOverlayClose = document.querySelector(".search-overlay-close");

    function isMobileView() {
        return window.innerWidth <= 768;
    }

    function toggleSearchOverlay() {
        if (isMobileView()) {
            searchOverlay.classList.toggle("active");
        }
    }

    // Event listeners
    if (mobileSearchIcon) {
        mobileSearchIcon.addEventListener("click", toggleSearchOverlay);
    }

    if (searchOverlayClose) {
        searchOverlayClose.addEventListener("click", function() {
            searchOverlay.classList.remove("active");
        });
    }

    // Optionally, handle window resize events to update the state as necessary
    window.addEventListener("resize", function() {
        if (!isMobileView()) {
            searchOverlay.classList.remove("active");
        }
    });

    /*============ Toggle Profile Dropdown Start Here ============*/
    const profileButton = document.querySelector('.profile');
    const profileDropdown = document.querySelector('.profile-dropdown');

    profileButton.addEventListener('click', (e) => {
        e.stopPropagation();
        profileDropdown.classList.toggle('active');
    });

    document.addEventListener('click', (e) => {
        if (profileDropdown.classList.contains('active') &&
            !profileDropdown.contains(e.target) &&
            !profileButton.contains(e.target)) {
            profileDropdown.classList.remove('active');
        }
    });
    /*============ Toggle Profile Dropdown End Here ============*/
});
