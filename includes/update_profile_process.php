<?php
require_once 'auth.php';

header('Content-Type: application/json');

try {
    // Start transaction
    $conn->beginTransaction();

    // Sanitize and validate inputs
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $current_password = $_POST['current_password'] ?? '';

    // Mandatory current password check for ALL updates
    $user = getCurrentUserData();
    if (!password_verify($current_password, $user['password'])) {
        throw new Exception("Current password is required and must be correct to update profile.");
    }

    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($email)) {
        throw new Exception("First name, last name, and email are required.");
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email format.");
    }

    // Handle image upload
    $image_path = null;
    if (!empty($_FILES['avatar']['name'])) {
        $target_dir = __DIR__ . '/../uploads/';
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_name = time() . '_' . basename($_FILES['avatar']['name']);
        $target_file = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate file type
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowed_types)) {
            throw new Exception("Only JPG, JPEG, PNG, and GIF files are allowed.");
        }

        // Move the file
        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file)) {
            throw new Exception("Failed to upload image.");
        }

        $image_path = 'uploads/' . $file_name;
    }

    // Password update logic
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    $update_fields = [
        'first_name = :first_name',
        'last_name = :last_name',
        'email = :email',
        'phone = :phone'
    ];

    if (!empty($image_path)) {
        $update_fields[] = 'image = :image';
    }

    // Optional password change logic
    if (!empty($new_password)) {
        if (strlen($new_password) < 8) {
            throw new Exception("New password must be at least 8 characters long.");
        }

        if ($new_password !== $confirm_password) {
            throw new Exception("New passwords do not match.");
        }

        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_fields[] = 'password = :password';
    }

    $update_query = "UPDATE tbl_account SET " . implode(', ', $update_fields) . " WHERE id = :user_id";
    $stmt = $conn->prepare($update_query);

    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);

    if (!empty($image_path)) {
        $stmt->bindParam(':image', $image_path);
    }

    if (!empty($new_password)) {
        $stmt->bindParam(':password', $hashed_password);
    }

    $stmt->execute();
    $conn->commit();

    // Update session variables
    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;
    if (!empty($image_path)) {
        $_SESSION['image'] = $image_path;
    }

    echo json_encode([
        'success' => true,
        'message' => 'Profile updated successfully!',
        'first_name' => $first_name,
        'last_name' => $last_name,
        'image' => $image_path
    ]);
    exit();

} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
    exit();
}
?>