<?php 
require_once 'auth.php';

// The specific string-based ID you want to use
$specificId = 'e71736c971c3451ae162fb330fada675b20a0b6b5f2091263f';

// You could also get this ID dynamically from a URL parameter or form submission
// $specificId = $_GET['id'] ?? $_POST['id'] ?? 'e71736c971c3451ae162fb330fada675b20a0b6b5f2091263f';

$settings = [];

// Query to get the specific row using the string ID
$stmt = $conn->prepare("SELECT * FROM tbl_settings WHERE id = ?");
$stmt->execute([$specificId]);
$settings = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

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