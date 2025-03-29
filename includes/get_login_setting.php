<?php 
require_once 'auth.php';
// Get current user settings
$settings = getUserSettings(); // Fetch from database or another source

// Check if getUserSettings() function is correct and fetching data
function getUserSettings() {
    // simulate fetching user settings from a data source
    return [
        'dark_mode' => 1, // Assume a value from user settings
        // other user-specific settings
    ];
}

// Ensure defaults are applied if needed
$defaultSettings = [
    'two_factor_enabled' => 0,
    'login_notifications' => 1,
    'password_change_required' => 1,
    'show_profile_picture' => 1,
    'show_activity_status' => 1,
    'email_notifications' => 1,
    'push_notifications' => 1,
    'password_expiry_alerts' => 1,
    'auto_lock' => 1,
    'clipboard_clear' => 1,
    'dark_mode' => 0
];

$settings = array_merge($defaultSettings, $settings);
?>