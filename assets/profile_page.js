document.addEventListener('DOMContentLoaded', function() {
    // 1. Avatar Preview Functionality
    const avatarUpload = document.getElementById('avatarUpload');
    const avatarPreview = document.getElementById('avatarPreview');
    
    if (avatarUpload && avatarPreview) {
        avatarUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarPreview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // 2. Password Visibility Toggle
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });

    // 3. Form Validation Function
    function validateForm() {
        const firstName = document.getElementById('firstName')?.value.trim();
        const lastName = document.getElementById('lastName')?.value.trim();
        const email = document.getElementById('email')?.value.trim();
        const currentPassword = document.getElementById('currentPassword')?.value;

        // Validate basic fields
        if (!firstName || !lastName || !email) {
            $.notify('First name, last name, and email are required', 'error');
            return false;
        }

        // Email format validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            $.notify('Please enter a valid email address', 'error');
            return false;
        }

        // Current password is ALWAYS required for any update
        if (!currentPassword) {
            $.notify('Current password is required to update profile', 'error');
            return false;
        }

        // Check if passwords are being changed
        const newPassword = document.getElementById('newPassword')?.value;
        const confirmPassword = document.getElementById('confirmPassword')?.value;
        
        if (newPassword || confirmPassword) {
            // New password specific validations
            if (!newPassword || !confirmPassword) {
                $.notify('Please fill both new password fields', 'error');
                return false;
            }
            
            // Check password match
            if (newPassword !== confirmPassword) {
                $.notify('New passwords do not match', 'error');
                return false;
            }
            
            // Check password length
            if (newPassword.length < 8) {
                $.notify('Password must be at least 8 characters long', 'error');
                return false;
            }
        }
        
        return true;
    }

    // 4. Form Submission Handler
    const updateProfileForm = document.getElementById('updateProfileForm');
    
    if (updateProfileForm) {
        updateProfileForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Form validation
            if (!validateForm()) {
                return;
            }
            
            const form = e.target;
            const formData = new FormData(form);
            const saveButton = form.querySelector('.save-profile');
            const originalButtonText = saveButton.textContent;
            
            try {
                // Show loading state
                saveButton.disabled = true;
                saveButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
                
                const response = await fetch('includes/update_profile_process.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (!data.success) {
                    throw new Error(data.message || 'Failed to update profile');
                }
                
                // Update UI with new data
                updateProfileUI(data);
                
                // Show success message using $.notify
                $.notify(data.message, "success");
                
            } catch (error) {
                // Show error message using $.notify
                $.notify(error.message, "error");
                console.error('Update error:', error);
            } finally {
                // Restore button state
                saveButton.disabled = false;
                saveButton.textContent = originalButtonText;
            }
        });
    }

    // 5. Update Profile UI Function
    function updateProfileUI(data) {
        // Update avatar if changed
        if (data.image) {
            const avatarPreview = document.getElementById('avatarPreview');
            if (avatarPreview) {
                avatarPreview.src = data.image + '?t=' + new Date().getTime(); // Cache busting
            }
        }
        
        // Update user name
        const userNameElement = document.querySelector('.user-name');
        if (userNameElement && data.first_name && data.last_name) {
            userNameElement.textContent = `${data.first_name} ${data.last_name}`;
        }
        
        // Clear password fields
        document.getElementById('newPassword').value = '';
        document.getElementById('confirmPassword').value = '';
        document.getElementById('currentPassword').value = '';
    }
});