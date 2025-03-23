document.addEventListener('DOMContentLoaded', function () {
    // Define the desired length of the password according to the user's requirement
    const DESIRED_PASSWORD_LENGTH = 16;  // match "hgD?QRa@Q*~4YGk<"

    // Character sets
    const uppercaseChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const lowercaseChars = 'abcdefghijklmnopqrstuvwxyz';
    const numberChars = '0123456789';
    const symbolChars = '!@#$%^&*()_-+={}[]|:;<>,.?/~';
    const similarChars = 'il1Lo0O';

    // Get all DOM elements
    const lengthSlider = document.getElementById('passwordLength');
    const lengthValue = document.getElementById('lengthValue');
    const includeUppercase = document.getElementById('includeUppercase');
    const includeLowercase = document.getElementById('includeLowercase');
    const includeNumbers = document.getElementById('includeNumbers');
    const includeSymbols = document.getElementById('includeSymbols');
    const excludeSimilar = document.getElementById('excludeSimilar');
    const generateButton = document.getElementById('generateButton');
    const generatedPassword = document.getElementById('generatedPassword');
    const copyPassword = document.getElementById('copyPassword');
    const refreshPassword = document.getElementById('refreshPassword');
    const strengthMeter = document.querySelector('.meter-fill');
    const strengthText = document.querySelector('.strength-text');
    const passwordHistoryList = document.getElementById('passwordHistoryList');
    const clearHistory = document.getElementById('clearHistory');

    // Initialize password history array
    let passwordHistory = JSON.parse(localStorage.getItem('passwordHistory')) || [];

    // Add styling for small screen display
    const styleElement = document.createElement('style');
    styleElement.textContent = `
/* Utility class for small screen display */
@media (min-width: 576px) {
    .d-sm-none {
        display: none !important;
    }
}

@media (max-width: 575px) {
    .mobile-hidden-password {
        display: none !important;
    }
    .mobile-password-placeholder {
        display: inline-flex !important;
    }
}

@media (min-width: 576px) {
    .mobile-hidden-password {
        display: inline !important;
    }
    .mobile-password-placeholder {
        display: none !important;
    }
}

/* Animation for dialog */
@keyframes dialogFadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

.password-dialog {
    animation: dialogFadeIn 0.2s ease-out;
}
`;
    document.head.appendChild(styleElement);

    // Event listener for length slider
    lengthSlider.addEventListener('input', function () {
        lengthValue.textContent = this.value;
    });

    // Generate password function ensuring specific length
    function generatePassword() {
        const length = parseInt(lengthSlider.value);
        let charset = '';

        // Build character set based on options
        if (includeUppercase.checked) charset += uppercaseChars;
        if (includeLowercase.checked) charset += lowercaseChars;
        if (includeNumbers.checked) charset += numberChars;
        if (includeSymbols.checked) charset += symbolChars;

        // Remove similar characters if option is checked
        if (excludeSimilar.checked) {
            for (let i = 0; i < similarChars.length; i++) {
                charset = charset.replace(similarChars[i], '');
            }
        }

        // Ensure at least one option is selected
        if (charset === '') {
            $.notify('Please select at least one character set option', 'warning');
            includeLowercase.checked = true;
            charset = lowercaseChars;
        }

        // Generate a password of the exact desired length
        let password = '';
        for (let i = 0; i < length; i++) {
            const randomIndex = Math.floor(Math.random() * charset.length);
            password += charset[randomIndex];
        }

        // Ensure password meets complexity requirements
        password = checkPasswordComplexity(password, length);

        return password;
    }

    function checkPasswordComplexity(password, length) {
        // Check if password includes at least one of each required character type
        if (includeUppercase.checked && !/[A-Z]/.test(password)) {
            const randomIndex = Math.floor(Math.random() * length);
            const randomChar = uppercaseChars.charAt(Math.floor(Math.random() * uppercaseChars.length));
            password = password.substring(0, randomIndex) + randomChar + password.substring(randomIndex + 1);
        }

        if (includeLowercase.checked && !/[a-z]/.test(password)) {
            const randomIndex = Math.floor(Math.random() * length);
            const randomChar = lowercaseChars.charAt(Math.floor(Math.random() * lowercaseChars.length));
            password = password.substring(0, randomIndex) + randomChar + password.substring(randomIndex + 1);
        }

        if (includeNumbers.checked && !/[0-9]/.test(password)) {
            const randomIndex = Math.floor(Math.random() * length);
            const randomChar = numberChars.charAt(Math.floor(Math.random() * numberChars.length));
            password = password.substring(0, randomIndex) + randomChar + password.substring(randomIndex + 1);
        }

        if (includeSymbols.checked && !/[!@#$%^&*()_+{}[\]:;<>,.?/~]/.test(password)) {
            const randomIndex = Math.floor(Math.random() * length);
            const randomChar = symbolChars.charAt(Math.floor(Math.random() * symbolChars.length));
            password = password.substring(0, randomIndex) + randomChar + password.substring(randomIndex + 1);
        }

        return password;
    }

    // Calculate password strength and update UI
    function calculatePasswordStrength(password) {
        let strength = 0;

        // Length contribution (up to 40%)
        strength += Math.min(40, (password.length / 32) * 40);

        // Character set contribution (up to 60%)
        if (/[A-Z]/.test(password)) strength += 15;
        if (/[a-z]/.test(password)) strength += 15;
        if (/[0-9]/.test(password)) strength += 15;
        if (/[^A-Za-z0-9]/.test(password)) strength += 15;

        // Update UI
        strengthMeter.style.width = strength + '%';

        // Set color and text based on strength
        let strengthCategory;
        if (strength < 40) {
            strengthMeter.style.backgroundColor = 'var(--danger)';
            strengthText.textContent = 'Weak';
            strengthText.style.color = 'var(--danger)';
            strengthCategory = 'weak';
        } else if (strength < 70) {
            strengthMeter.style.backgroundColor = 'var(--warning)';
            strengthText.textContent = 'Medium';
            strengthText.style.color = 'var(--warning)';
            strengthCategory = 'medium';
        } else {
            strengthMeter.style.backgroundColor = 'var(--success)';
            strengthText.textContent = 'Strong';
            strengthText.style.color = 'var(--success)';
            strengthCategory = 'strong';
        }

        return {
            score: strength,
            category: strengthCategory
        };
    }

    // Add password to history
    function addToHistory(password, strength) {
        // Create history item object
        const historyItem = {
            password: password,
            strength: strength,
            timestamp: new Date().toISOString(),
        };

        // Add to the beginning of the array (most recent first)
        passwordHistory.unshift(historyItem);

        // Limit history to 10 items
        if (passwordHistory.length > 10) {
            passwordHistory = passwordHistory.slice(0, 10);
        }

        // Save to localStorage
        localStorage.setItem('passwordHistory', JSON.stringify(passwordHistory));

        // Update UI
        renderHistoryList();
    }

    // Create a masked version of the password for mobile view
    function createMaskedPassword(password) {
        if (!password) return '';
        // Show the first and last character, mask the rest with dots
        if (password.length <= 2) return password;
        return password.charAt(0) + '●'.repeat(Math.min(password.length - 2, 8)) + password.charAt(password.length - 1);
    }

    // Render history list
    function renderHistoryList() {
        // Clear current list
        passwordHistoryList.innerHTML = '';

        // Show empty message if no history
        if (passwordHistory.length === 0) {
            passwordHistoryList.innerHTML = '<div class="empty-history">No password history yet</div>';
            return;
        }

        // Add each history item to the list
        passwordHistory.forEach((item, index) => {
            const li = document.createElement('li');
            li.className = 'history-item';

            // Format the date
            const date = new Date(item.timestamp);
            const formattedDate = date.toLocaleString();

            // Create tag for strength
            const strengthClass = item.strength.category;
            const strengthLabel = item.strength.category.charAt(0).toUpperCase() + item.strength.category.slice(1);
            
            // Create masked password for mobile view
            const maskedPassword = createMaskedPassword(item.password);

            li.innerHTML = `
        <div class="history-password">
            <span class="password-tag ${strengthClass}">${strengthLabel}</span>
            <span class="mobile-hidden-password">${item.password}</span>
            <span class="mobile-password-placeholder">${maskedPassword}</span>
        </div>
        <div class="history-info">
            <span class="history-date">${formattedDate}</span>
            <div class="history-actions">
                <button class="action-btn view-history" data-index="${index}" title="View Password">
                    <i class="bi bi-eye"></i>
                </button>
                <button class="action-btn copy-history" data-index="${index}" title="Copy Password">
                    <i class="bi bi-clipboard"></i>
                </button>
                <button class="action-btn use-history" data-index="${index}" title="Use This Password">
                    <i class="bi bi-arrow-clockwise"></i>
                </button>
                <button class="action-btn delete-history" data-index="${index}" title="Remove">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        </div>
    `;

            passwordHistoryList.appendChild(li);
        });

        // Add event listeners to the history item buttons
        document.querySelectorAll('.copy-history').forEach(button => {
            button.addEventListener('click', function () {
                const index = parseInt(this.dataset.index);
                copyToClipboard(passwordHistory[index].password);
            });
        });

        document.querySelectorAll('.use-history').forEach(button => {
            button.addEventListener('click', function () {
                const index = parseInt(this.dataset.index);
                const selectedPassword = passwordHistory[index].password;
                generatedPassword.value = selectedPassword;

                // Recalculate and display strength properly
                const strengthResult = calculatePasswordStrength(selectedPassword);

                // Show notification
                $.notify('Password loaded from history', 'success');
            });
        });

        document.querySelectorAll('.delete-history').forEach(button => {
            button.addEventListener('click', function () {
                const index = parseInt(this.dataset.index);
                passwordHistory.splice(index, 1);
                localStorage.setItem('passwordHistory', JSON.stringify(passwordHistory));
                renderHistoryList();
                $.notify('Password removed from history', 'success');
            });
        });

        // Add event listeners for the view password button
        document.querySelectorAll('.view-history').forEach(button => {
            button.addEventListener('click', function () {
                const index = parseInt(this.dataset.index);
                const password = passwordHistory[index].password;
                showPasswordDialog(password);
            });
        });
    }

    // Function to show password in dialog
    function showPasswordDialog(password) {
        // Create modal overlay
        const overlay = document.createElement('div');
        overlay.className = 'modal-overlay';
        overlay.style.position = 'fixed';
        overlay.style.top = '0';
        overlay.style.left = '0';
        overlay.style.width = '100%';
        overlay.style.height = '100%';
        overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
        overlay.style.display = 'flex';
        overlay.style.alignItems = 'center';
        overlay.style.justifyContent = 'center';
        overlay.style.zIndex = '1060';

        // Create modal dialog
        const dialog = document.createElement('div');
        dialog.className = 'password-dialog';
        dialog.style.backgroundColor = 'white';
        dialog.style.borderRadius = '0px';
        dialog.style.padding = '20px';
        dialog.style.maxWidth = '90%';
        dialog.style.width = '400px';
        dialog.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.2)';

        dialog.innerHTML = `
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <h3 style="margin: 0; color: var(--text);">Password</h3>
        <button class="close-dialog" style="background: none; border: none; font-size: 20px; cursor: pointer;">
            <i class="bi bi-x"></i>
        </button>
    </div>
    <div style="margin-bottom: 20px;">
        <input type="text" value="${password}" readonly style="width: 100%; padding: 10px; font-family: monospace; letter-spacing: 1px; border: 1px solid var(--border); border-radius: 0px;">
    </div>
    <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button class="copy-dialog-password" style="background-color: var(--primary); color: white; border: none; padding: 8px 15px; border-radius: 0px; cursor: pointer;">
            <i class="bi bi-clipboard"></i> Copy
        </button>
        <button class="close-dialog-btn" style="background-color: var(--light-bg); color: var(--text); border: none; padding: 8px 15px; border-radius: 0px; cursor: pointer;">
            Close
        </button>
    </div>
`;

        overlay.appendChild(dialog);
        document.body.appendChild(overlay);

        // Add event listeners for dialog buttons
        dialog.querySelector('.close-dialog').addEventListener('click', () => {
            document.body.removeChild(overlay);
        });

        dialog.querySelector('.close-dialog-btn').addEventListener('click', () => {
            document.body.removeChild(overlay);
        });

        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                document.body.removeChild(overlay);
            }
        });

        dialog.querySelector('.copy-dialog-password').addEventListener('click', () => {
            copyToClipboard(password);
        });
    }

    // Copy to clipboard function
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            $.notify('Password copied to clipboard!', 'success');
        }).catch(err => {
            console.error('Could not copy text: ', err);
            $.notify('Failed to copy password', 'error');
        });
    }

    // Event Listeners
    generateButton.addEventListener('click', function () {
        const newPassword = generatePassword();
        generatedPassword.value = newPassword;
        const strengthResult = calculatePasswordStrength(newPassword);
        addToHistory(newPassword, strengthResult);
    });

    refreshPassword.addEventListener('click', function () {
        const newPassword = generatePassword();
        generatedPassword.value = newPassword;
        const strengthResult = calculatePasswordStrength(newPassword);
        addToHistory(newPassword, strengthResult);
    });

    copyPassword.addEventListener('click', function () {
        copyToClipboard(generatedPassword.value);
    });

    clearHistory.addEventListener('click', function () {
        if (confirm('Are you sure you want to clear your password history?')) {
            passwordHistory = [];
            localStorage.removeItem('passwordHistory');
            renderHistoryList();
            $.notify('Password history cleared', 'success');
        }
    });

    // Generate a password immediately when the page loads and render history
    window.addEventListener('load', function () {
        const initialPassword = generatePassword();
        generatedPassword.value = initialPassword;
        const strengthResult = calculatePasswordStrength(initialPassword);

        // Only add to history if we're generating a new password
        // (not just showing the history on page load)
        if (passwordHistory.length === 0 ||
            passwordHistory[0].password !== initialPassword) {
            addToHistory(initialPassword, strengthResult);
        } else {
            renderHistoryList();
        }
    });
});