/**
 * Dark Mode Functionality for SecureVault
 * Handles dark mode toggle and persistence
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get the dark mode toggle input
    const darkModeToggle = document.querySelector('input[name="dark_mode"]');
    
    if (darkModeToggle) {
        // Initialize dark mode based on current setting
        updateDarkModeClass(darkModeToggle.checked);
        
        // Add event listener for toggle changes
        darkModeToggle.addEventListener('change', function() {
            updateDarkModeClass(this.checked);
        });
    }
    
    /**
     * Update dark mode class on HTML element
     * @param {boolean} isDarkMode - Whether dark mode is active
     */
    function updateDarkModeClass(isDarkMode) {
        document.documentElement.classList.toggle('dark-mode', isDarkMode);
    }
    
    /**
     * Apply dark mode after settings save
     * @param {boolean} isDarkMode - Whether dark mode should be activated
     */
    window.applyDarkMode = function(isDarkMode) {
        updateDarkModeClass(isDarkMode);
    };
});