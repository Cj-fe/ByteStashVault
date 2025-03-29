document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('settingsForm');
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            const submitButton = form.querySelector('.save-profile');
            const buttonText = submitButton.querySelector('.button-text');
            const spinner = submitButton.querySelector('.spinner-border');
            
            try {
                // Show loading state
                submitButton.disabled = true;
                buttonText.textContent = 'Saving...';
                spinner.classList.remove('d-none');
                
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Show success notification
                    $.notify(result.message || 'Settings saved successfully', {
                        className: 'success',
                        position: 'top right'
                    });
                    
                    // Update dark mode immediately if changed using the function from darkmode.js
                    window.applyDarkMode(formData.get('dark_mode') === 'on');
                } else {
                    throw new Error(result.message || 'Failed to save settings');
                }
            } catch (error) {
                // Show error notification
                $.notify(error.message, {
                    className: 'error',
                    position: 'top right'
                });
                console.error('Error:', error);
            } finally {
                // Restore button state
                submitButton.disabled = false;
                buttonText.textContent = 'Save Settings';
                spinner.classList.add('d-none');
            }
        });
    }
});