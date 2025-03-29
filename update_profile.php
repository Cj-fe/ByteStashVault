<!-- update_profile.php -->
<?php 
require_once 'includes/auth.php';
require_once 'includes/get_setting.php'; ?>


<?php
// Fetch current user data
$user = getCurrentUserData();

// Redirect if user data cannot be retrieved
if (!$user) {
    $_SESSION['error'] = "Unable to retrieve user data";
    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureVault - Update Profile</title>
    <?php include 'includes/header.php'; ?>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">

</head>

<body class="<?php echo $settings['dark_mode'] ? 'dark-mode' : ''; ?>">

    <?php include 'includes/loading.php'; ?>


    <?php include 'includes/navbar.php'; ?>

    <main>
        <div class="container">
            <?php include 'includes/aside.php'; ?>

            <section class="content">
                <div class="password-header">
                    <h2>Update Profile</h2>
                </div>

                <div class="profile-update-container">
                    <form id="updateProfileForm" class="profile-form" method="POST"
                        action="includes/update_profile_process.php" enctype="multipart/form-data">
                        <div class="profile-section">
                            <div class="profile-avatar">
                                <div class="avatar-preview">
                                    <div class="image-container">
                                        <img src="<?php echo htmlspecialchars($user['image'] ?? 'assets/images/default-avatar.png'); ?>"
                                            alt="Profile Avatar" id="avatarPreview">
                                    </div>
                                    <div class="online-badge"></div>
                                </div>
                                <div class="avatar-details">
                                    <div class="user-name">
                                        <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
                                    </div>
                                    <div class="avatar-upload">
                                        <label for="avatarUpload" class="upload-btn">
                                            <i class="bi bi-camera"></i>
                                            Change Photo
                                        </label>
                                        <input type="file" id="avatarUpload" name="avatar" accept="image/*"
                                            style="display: none;">
                                    </div>
                                </div>
                            </div>
                            <div class="form-section">
                                <div class="form-group">
                                    <label for="firstName">First Name</label>
                                    <input type="text" id="firstName" name="first_name"
                                        value="<?php echo htmlspecialchars($user['first_name'] ?? ''); ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="lastName">Last Name</label>
                                    <input type="text" id="lastName" name="last_name"
                                        value="<?php echo htmlspecialchars($user['last_name'] ?? ''); ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" id="email" name="email"
                                        value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" id="phone" name="phone"
                                        value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                                </div>
                            </div>

                            <div class="form-section">
                                <h3>Change Password</h3>
                                <p class="section-description">Leave blank to keep your current password</p>



                                <div class="form-group">
                                    <label for="newPassword">New Password</label>
                                    <div class="password-input-container">
                                        <input type="password" id="newPassword" name="new_password">
                                        <button type="button" class="toggle-password">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="confirmPassword">Confirm New Password</label>
                                    <div class="password-input-container">
                                        <input type="password" id="confirmPassword" name="confirm_password">
                                        <button type="button" class="toggle-password">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="currentPassword">Current Password</label>
                                    <div class="password-input-container">
                                        <input type="password" id="currentPassword" name="current_password">
                                        <button type="button" class="toggle-password">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="cancel-button"
                                    onclick="window.history.back()">Cancel</button>
                                <button type="submit" class="save-profile">Save Changes</button>
                            </div>
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