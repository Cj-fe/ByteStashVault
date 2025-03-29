<?php 
require_once 'auth.php';
// Get current user settings
$userId = $_SESSION['user_id'] ?? null;
$settings = [];

if ($userId) {
    $stmt = $conn->prepare("SELECT * FROM tbl_settings WHERE id = ?");
    $stmt->execute([$userId]);
    $settings = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
}

// Set default values if no settings exist
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