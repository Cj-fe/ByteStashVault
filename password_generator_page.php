<?php require_once 'includes/auth.php'; ?>
<?php require_once 'includes/conn.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureVault - Password Generator</title>
    <?php include 'includes/header.php'; ?>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/style.css">
    
</head>

<body>
    <div id="loading">
        <div id="lottie-animation" style="width:300px; height:300px;"></div>
    </div>
    <?php include 'includes/navbar.php'; ?>

    <main>
        <div class="container">

            <?php include 'includes/aside.php'; ?>

            <section class="content">
                <div class="password-header">
                    <h2>Password Generator</h2>
                </div>

                <!-- Password Generator Options -->
                <div class="generator-container">
                    <div class="generator-options">
                        <div class="form-group">
                            <label for="passwordLength">Password Length</label>
                            <input type="range" id="passwordLength" min="8" max="32" value="16" class="range-slider">
                            <span id="lengthValue">16</span>
                        </div>

                        <div class="options-grid">
                            <div class="form-group checkbox-group">
                                <input type="checkbox" id="includeUppercase" checked>
                                <label for="includeUppercase">Include Uppercase (A-Z)</label>
                            </div>

                            <div class="form-group checkbox-group">
                                <input type="checkbox" id="includeLowercase" checked>
                                <label for="includeLowercase">Include Lowercase (a-z)</label>
                            </div>

                            <div class="form-group checkbox-group">
                                <input type="checkbox" id="includeNumbers" checked>
                                <label for="includeNumbers">Include Numbers (0-9)</label>
                            </div>

                            <div class="form-group checkbox-group">
                                <input type="checkbox" id="includeSymbols" checked>
                                <label for="includeSymbols">Include Symbols (@#$%)</label>
                            </div>

                            <div class="form-group checkbox-group">
                                <input type="checkbox" id="excludeSimilar">
                                <label for="excludeSimilar">Exclude Similar Characters (i, l, 1, o, 0)</label>
                            </div>
                        </div>

                        <button id="generateButton" class="add-button">
                            <i class="bi bi-shield-lock"></i> Generate Strong Password
                        </button>
                    </div>

                    <!-- Generated Password Display -->
                    <div class="generated-password">
                        <div class="password-strength-meter">
                            <div class="strength-label">Password Strength:</div>
                            <div class="meter-bar">
                                <div class="meter-fill" style="width: 80%; background-color: var(--success);"></div>
                            </div>
                            <div class="strength-text">Strong</div>
                        </div>

                        <div class="password-output">
                            <input type="text" id="generatedPassword" value="" readonly>
                            <div class="password-actions">
                                <button class="action-btn" title="Copy Password" id="copyPassword">
                                    <i class="bi bi-clipboard"></i>
                                </button>
                                <button class="action-btn" title="Refresh" id="refreshPassword">
                                    <i class="bi bi-arrow-repeat"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Password History Section -->
                <div class="password-history-container">
                    <div class="history-header">
                        <h3>Password History</h3>
                        <button class="clear-history" id="clearHistory">
                            <i class="bi bi-trash"></i> Clear History
                        </button>
                 </div>
                    <ul class="password-history-list" id="passwordHistoryList">
                        <!-- Dynamic content will be inserted here -->
                    </ul>
                </div>
            </section>
        </div>
    </main>

    <?php include 'partials/modal.php'; ?>
    <?php include 'partials/footer.php'; ?>

</body>

</html>