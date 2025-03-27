<?php
require_once 'auth.php';
header('Content-Type: application/json');

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit();
}

// Get the current user ID
$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit();
}

// Prepare the update data
$updateData = [
    'two_factor_enabled' => isset($_POST['two_factor']) ? 1 : 0,
    'login_notifications' => isset($_POST['login_notifications']) ? 1 : 0,
    'password_change_required' => isset($_POST['password_change_required']) ? 1 : 0,
    'show_profile_picture' => isset($_POST['show_profile_picture']) ? 1 : 0,
    'show_activity_status' => isset($_POST['show_activity_status']) ? 1 : 0,
    'email_notifications' => isset($_POST['email_notifications']) ? 1 : 0,
    'push_notifications' => isset($_POST['push_notifications']) ? 1 : 0,
    'password_expiry_alerts' => isset($_POST['password_expiry_alerts']) ? 1 : 0,
    'auto_lock' => isset($_POST['auto_lock']) ? 1 : 0,
    'clipboard_clear' => isset($_POST['clipboard_clear']) ? 1 : 0,
    'dark_mode' => isset($_POST['dark_mode']) ? 1 : 0,
    'updated_at' => date('Y-m-d H:i:s')
];

try {
    // Check if settings exist for this user
    $checkStmt = $conn->prepare("SELECT id FROM tbl_settings WHERE id = ?");
    $checkStmt->execute([$userId]);
    $settingsExist = $checkStmt->fetch();

    if ($settingsExist) {
        // Update existing settings
        $setClause = implode(', ', array_map(function($field) {
            return "$field = :$field";
        }, array_keys($updateData)));

        $sql = "UPDATE tbl_settings SET $setClause WHERE id = :id";
        $updateData['id'] = $userId;
    } else {
        // Insert new settings
        $columns = implode(', ', array_keys($updateData));
        $placeholders = ':' . implode(', :', array_keys($updateData));
        $sql = "INSERT INTO tbl_settings ($columns, id) VALUES ($placeholders, :id)";
        $updateData['id'] = $userId;
    }

    // Prepare and execute the query
    $stmt = $conn->prepare($sql);
    $stmt->execute($updateData);

    // Update session with new settings if needed
    $_SESSION['dark_mode'] = $updateData['dark_mode'];

    echo json_encode([
        'success' => true,
        'message' => 'Settings updated successfully'
    ]);
    exit();

} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to update settings. Please try again.'
    ]);
    exit();
}