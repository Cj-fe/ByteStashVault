
<?php require_once 'includes/auth.php'; ?>
<?php require_once 'includes/conn.php'; ?>

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
    <style>
        /* Avatar Preview Styles */
        .profile-avatar {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 2rem;
            width: 100%;
        }

        .avatar-preview {
            position: relative;
            width: 150px;
            height: 150px;
        }

        .avatar-preview .image-container {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            overflow: hidden;
            background-color: var(--light-bg);
            border: 3px solid var(--primary);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .avatar-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-name {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.50rem;
            color: var(--text);
            margin: 1rem 0;

            text-align: center;
        }

        /* Online Badge Styles */
        .online-badge {
            position: absolute;
            bottom: 5px;
            right: 15px;
            width: 25px;
            height: 25px;
            background-color: #2ecc71;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .online-badge.offline {
            background-color: #e74c3c;
        }

        .avatar-upload {
            margin-top: 0.5rem;
            text-align: center;
        }

        .upload-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background-color: var(--light-bg);
            border: 1px solid var(--border);
            border-radius: 20px;
            color: var(--text);
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.875rem;
        }

        .upload-btn:hover {
            background-color: var(--primary);
            color: white;
        }

        /* Responsive Styles */
        @media (min-width: 769px) {
            .profile-avatar {
                flex-direction: row;
                justify-content: flex-start;
                align-items: center;
                gap: 2rem;
            }

            .avatar-details {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
            }

            .user-name {
                text-align: left;
                margin: 0 0 1rem 0;
            }

            .avatar-upload {
                margin-top: 0;
                text-align: left;
            }
        }

        @media (max-width: 768px) {
            .avatar-preview {
                width: 120px;
                height: 120px;
            }

            .online-badge {
                width: 16px;
                height: 16px;
                bottom: 8px;
                right: 8px;
            }
        }

        @media (max-width: 480px) {
            .avatar-preview {
                width: 100px;
                height: 100px;
            }

            .avatar-preview .image-container {
                border-width: 2px;
            }

            .online-badge {
                width: 14px;
                height: 14px;
                bottom: 6px;
                right: 6px;
                border-width: 2px;
            }

            .user-name {
                font-size: 1.1rem;
            }
        }
    </style>
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
                    <h2>Update Profile</h2>
                </div>

                <div class="profile-update-container">
                    <form id="updateProfileForm" class="profile-form" method="POST" action="update_profile_process.php"
                        enctype="multipart/form-data">
                        <div class="profile-section">
                            <div class="profile-avatar">
                                <div class="avatar-preview">
                                    <div class="image-container">
                                        <img src="uploads/<?php echo htmlspecialchars($user['image'] ?? 'assets/images/default-avatar.png'); ?>"
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
                                        <label for="currentPassword">Current Password</label>
                                        <div class="password-input-container">
                                            <input type="password" id="currentPassword" name="current_password">
                                            <button type="button" class="toggle-password">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>

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
                                </div>

                                <div class="form-actions">
                                    <button type="button" class="cancel-button"
                                        onclick="window.history.back()">Cancel</button>
                                    <button type="submit" class="save-button">Save Changes</button>
                                </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>

    <?php include 'partials/modal.php'; ?>
    <?php include 'partials/footer.php'; ?>

    <!-- Custom Script -->
    <script>
        // Avatar preview functionality
        document.getElementById('avatarUpload').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        // Password visibility toggle
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function () {
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

        // Form validation
        document.getElementById('updateProfileForm').addEventListener('submit', function (e) {
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (newPassword || confirmPassword) {
                if (newPassword !== confirmPassword) {
                    e.preventDefault();
                    alert('New passwords do not match!');
                }
            }
        });

        // Real-time online status update
        function updateOnlineStatus() {
            fetch('check_online_status.php')
                .then(response => response.json())
                .then(data => {
                    const onlineBadge = document.querySelector('.online-badge');
                    if (data.is_online) {
                        onlineBadge.classList.remove('offline');
                    } else {
                        onlineBadge.classList.add('offline');
                    }
                });
        }

        // Update status every 30 seconds
        setInterval(updateOnlineStatus, 30000);
    </script>
</body>

</html>
