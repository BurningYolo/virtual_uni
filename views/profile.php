<?php
if (!defined('APP_RUNNING')) {
    die('Access denied'); // Stop execution if accessed directly
}

// Your existing code goes here...
?>


<div class="container-fluid p-4 main-content" id="mainContent">
    <h1 class="text-center mb-4">User Profile</h1>
    
    <div class="view_profile_card">
        <?php if (isset($user)): ?>
            <div class="view_profile_details text-center">
                <img src="<?php echo $user['profile_picture']?>" alt="Profile Picture" class="view_profile_picture">
                <h2 class="view_profile_username"><?php echo htmlspecialchars($user['username']); ?></h2>
                <p class="view_profile_bio"><strong>Bio:</strong> <?php echo nl2br(htmlspecialchars($user['bio'])); ?></p>
                <div class="view_profile_info">
                    <p><strong>First Name:</strong> <?php echo htmlspecialchars($user['first_name']); ?></p>
                    <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user['last_name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <br>
           
                    <p><strong> <?php echo htmlspecialchars($user['role']);  ?></strong></p>
                </div>

                <button class="btn btn-success">UPDATE INFO</button>
            </div>
        <?php else: ?>
            <p class="text-center">User information not found.</p>
        <?php endif; ?>
    </div>
</div>


<!-- Update Info Modal -->
<div class="modal fade view_profile_modal" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProfileModalLabel">Update Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateProfileForm" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea class="form-control" id="bio" name="bio"><?php echo htmlspecialchars($user['bio']); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">Profile Picture</label>
                        <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept=".png, .jpg">
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" disabled>
                            <option value="student" <?php echo $user['role'] == 'student' ? 'selected' : ''; ?>>Student</option>
                            <option value="teacher" <?php echo $user['role'] == 'teacher' ? 'selected' : ''; ?>>Teacher</option>
                        </select>
                    </div>
                </form>

                <!-- Feedback Message -->
                <div class="feedback-message" id="profileFeedback"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveProfileBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    document.querySelector('.btn-success').addEventListener('click', function() {
        var myModal = new bootstrap.Modal(document.getElementById('updateProfileModal'));
        myModal.show();
    });

    document.getElementById('saveProfileBtn').addEventListener('click', function() {
        var formData = new FormData(document.getElementById('updateProfileForm'));

        // Get the file input to check file format
        var profilePicture = document.getElementById('profile_picture').files[0];
        if (profilePicture && !['image/png', 'image/jpeg'].includes(profilePicture.type)) {
            showFeedback('Only PNG and JPG files are allowed!', 'error');
            return;
        }

        // Send AJAX request to the handler script
        fetch('./handlers/profile_handler.php?action=update', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === "User updated successfully.") {
                showFeedback('Profile updated successfully!', 'success');
            } else {
                showFeedback('Failed to update profile: ' + data.message, 'error');
            }
        })
        .catch(error => showFeedback('Error: ' + error.message, 'error'));
    });

    function showFeedback(message, type) {
        var feedbackElement = document.getElementById('profileFeedback');
        feedbackElement.textContent = message;
        feedbackElement.classList.remove('feedback-success', 'feedback-error');
        
        if (type === 'success') {
            feedbackElement.classList.add('feedback-success');
        } else {
            feedbackElement.classList.add('feedback-error');
        }

        feedbackElement.style.display = 'block';
    }
</script>

