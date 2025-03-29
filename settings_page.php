<?php
require_once 'includes/auth.php';
require_once 'includes/get_admin_setting.php';
?>

<!DOCTYPE html>
<html lang="en" class="<?php echo $settings['dark_mode'] ? 'dark-mode' : ''; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureVault - Settings</title>
    <?php include 'includes/header.php'; ?>
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <script src="assets/js/darkmode.js"></script>
</head>

<body>
    <?php include 'includes/loading.php'; ?>

    <?php include 'includes/navbar.php'; ?>

    <main>
        <div class="container">
            <?php include 'includes/aside.php'; ?>

            <section class="content">
                <div class="password-header">
                    <h2>Account Settings</h2>
                </div>

                <div class="settings-container">
                    <form id="settingsForm" class="settings-form" method="POST"
                        action="includes/update_settings_process.php">
                        <!-- Security Settings Section -->
                        <div class="settings-section">
                            <h3 class="section-title">
                                <i class="bi bi-shield-lock"></i>
                                Security Settings
                            </h3>

                            <div class="setting-item">
                                <div class="setting-info">
                                    <h4>Two-Factor Authentication</h4>
                                    <p>Add an extra layer of security to your account</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="two_factor" <?php echo $settings['two_factor_enabled'] ? 'checked' : ''; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>

                            <div class="setting-item">
                                <div class="setting-info">
                                    <h4>Login Notifications</h4>
                                    <p>Get notified when someone logs into your account</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="login_notifications" <?php echo $settings['login_notifications'] ? 'checked' : ''; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>

                            <div class="setting-item">
                                <div class="setting-info">
                                    <h4>Password Change Required</h4>
                                    <p>Require password change every 90 days</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="password_change_required" <?php echo $settings['password_change_required'] ? 'checked' : ''; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Privacy Settings Section -->
                        <div class="settings-section">
                            <h3 class="section-title">
                                <i class="bi bi-eye"></i>
                                Privacy Settings
                            </h3>

                            <div class="setting-item">
                                <div class="setting-info">
                                    <h4>Show Profile Picture</h4>
                                    <p>Allow other users to see your profile picture</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="show_profile_picture" <?php echo $settings['show_profile_picture'] ? 'checked' : ''; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>

                            <div class="setting-item">
                                <div class="setting-info">
                                    <h4>Activity Status</h4>
                                    <p>Show when you're active on the platform</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="show_activity_status" <?php echo $settings['show_activity_status'] ? 'checked' : ''; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Notification Settings Section -->
                        <div class="settings-section">
                            <h3 class="section-title">
                                <i class="bi bi-bell"></i>
                                Notification Settings
                            </h3>

                            <div class="setting-item">
                                <div class="setting-info">
                                    <h4>Email Notifications</h4>
                                    <p>Receive important updates via email</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="email_notifications" <?php echo $settings['email_notifications'] ? 'checked' : ''; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>

                            <div class="setting-item">
                                <div class="setting-info">
                                    <h4>Push Notifications</h4>
                                    <p>Get instant notifications on your device</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="push_notifications" <?php echo $settings['push_notifications'] ? 'checked' : ''; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>

                            <div class="setting-item">
                                <div class="setting-info">
                                    <h4>Password Expiry Alerts</h4>
                                    <p>Notify me before my passwords expire</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="password_expiry_alerts" <?php echo $settings['password_expiry_alerts'] ? 'checked' : ''; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Advanced Settings Section -->
                        <div class="settings-section">
                            <h3 class="section-title">
                                <i class="bi bi-gear"></i>
                                Advanced Settings
                            </h3>

                            <div class="setting-item">
                                <div class="setting-info">
                                    <h4>Auto-Lock After Inactivity</h4>
                                    <p>Lock the vault after 30 minutes of inactivity</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="auto_lock" <?php echo $settings['auto_lock'] ? 'checked' : ''; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>

                            <div class="setting-item">
                                <div class="setting-info">
                                    <h4>Clipboard Clear</h4>
                                    <p>Automatically clear copied passwords after 60 seconds</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="clipboard_clear" <?php echo $settings['clipboard_clear'] ? 'checked' : ''; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>

                            <div class="setting-item">
                                <div class="setting-info">
                                    <h4>Dark Mode</h4>
                                    <p>Switch between light and dark theme</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="dark_mode" <?php echo $settings['dark_mode'] ? 'checked' : ''; ?>>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Confirmed Settings Password Section -->
                        <div class="settings-section confirmed-password-section">
                            <h3 class="section-title">
                                <i class="bi bi-lock"></i>
                                Confirm Settings Changes
                            </h3>

                            <div class="setting-item form form-group">
                                <div class="setting-info">
                                    <h4>Confirm Password</h4>
                                    <p>Enter your current password to save changes</p>
                                </div>
                                <input type="password" name="confirmed_setting_password" id="confirmed_setting_password"
                                    placeholder="Enter your current password" required style="width: 50%;">
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="cancel-button" onclick="window.history.back()">Cancel</button>
                            <button type="submit" class="save-profile">
                                <span class="button-text">Save Settings</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>

    <?php include 'partials/modal.php'; ?>
    <?php include 'partials/footer.php'; ?>


</body>

</html>