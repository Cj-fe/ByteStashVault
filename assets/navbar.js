document.addEventListener("DOMContentLoaded", function() {
    // Select elements
    const mobileSearchIcon = document.querySelector(".mobile-search-icon");
    const searchOverlay = document.querySelector(".search-overlay");
    const searchOverlayClose = document.querySelector(".search-overlay-close");
    const desktopSearchBar = document.querySelector(".desktop-search input");
    const overlaySearchInput = document.querySelector(".search-overlay input");
    const passwordCards = document.querySelectorAll(".password-card"); // Elements for grid view
    const passwordListItems = document.querySelectorAll(".password-list-item"); // Elements for list view
    const searchResultMessage = document.getElementById('search-result-message');
    
    function isMobileView() {
        return window.innerWidth <= 768;
    }
    
    function toggleSearchOverlay() {
        if (isMobileView()) {
            searchOverlay.classList.toggle("active");
        }
    }
    
    function filterCards(searchInput) {
        const filterValue = searchInput.value.toLowerCase();
        let visibleCount = 0;

        // Filter grid view elements
        passwordCards.forEach(card => {
            const websiteNameElement = card.querySelector('h3');
            const usernameElement = card.querySelector('.username-field .detail-value');

            const websiteName = websiteNameElement ? websiteNameElement.textContent.toLowerCase() : '';
            const username = usernameElement ? usernameElement.textContent.toLowerCase() : '';

            if (websiteName.includes(filterValue) || username.includes(filterValue)) {
                card.style.display = "block";
                visibleCount++;
            } else {
                card.style.display = "none";
            }
        });

        // Filter list view elements
        passwordListItems.forEach(listItem => {
            const websiteNameElement = listItem.querySelector('h3');
            const usernameElement = listItem.querySelector('.username-field .detail-value');

            const websiteName = websiteNameElement ? websiteNameElement.textContent.toLowerCase() : '';
            const username = usernameElement ? usernameElement.textContent.toLowerCase() : '';

            if (websiteName.includes(filterValue) || username.includes(filterValue)) {
                listItem.style.display = "flex"; // or your list display style
                visibleCount++;
            } else {
                listItem.style.display = "none";
            }
        });

        if (visibleCount === 0 && filterValue.trim() !== '') {
            searchResultMessage.textContent = `Your search for: "${filterValue}" has no result`;
            searchResultMessage.style.display = 'block';
        } else {
            searchResultMessage.style.display = 'none';
        }

        
    }

    // Event listeners for toggling search overlay
    if (mobileSearchIcon) {
        mobileSearchIcon.addEventListener("click", toggleSearchOverlay);
    }

    if (searchOverlayClose) {
        searchOverlayClose.addEventListener("click", function() {
            searchOverlay.classList.remove("active");
        });
    }

    // Search filters for both desktop and mobile
    if (desktopSearchBar) {
        desktopSearchBar.addEventListener('input', function() {
            filterCards(desktopSearchBar);
        });
    }

    if (overlaySearchInput) {
        overlaySearchInput.addEventListener('input', function() {
            filterCards(overlaySearchInput);
        });
    }

    window.addEventListener("resize", function() {
        if (!isMobileView()) {
            searchOverlay.classList.remove("active");
        }
    });

    // Profile dropdown code
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
});