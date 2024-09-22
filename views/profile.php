<div class="container-fluid p-4 main-content" id="mainContent">
    <h1 class="text-center mb-4">User Profile</h1>
    
    <div class="view_profile_card">
        <?php if (isset($user)): ?>
            <div class="view_profile_details text-center">
                <img src="assets/images/download.jfif" alt="Profile Picture" class="view_profile_picture">
                <h2 class="view_profile_username"><?php echo htmlspecialchars($user['username']); ?></h2>
                <p class="view_profile_bio"><strong>Bio:</strong> <?php echo nl2br(htmlspecialchars($user['bio'])); ?></p>
                <div class="view_profile_info">
                    <p><strong>First Name:</strong> <?php echo htmlspecialchars($user['first_name']); ?></p>
                    <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user['last_name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <br>
                    <p><strong> <?php echo htmlspecialchars($user['role']);  ?></strong></p>
                </div>

                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editProfileModal">UPDATE INFO</button>
            </div>
        <?php else: ?>
            <p class="text-center">User information not found.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm">
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea class="form-control" id="bio" rows="3" required><?php echo htmlspecialchars($user['bio']); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('editProfileForm').addEventListener('submit', function(e) {
        e.preventDefault();  // Prevent form from submitting the default way

        const formData = new FormData();
        formData.append('first_name', document.getElementById('firstName').value);
        formData.append('last_name', document.getElementById('lastName').value);
        formData.append('email', document.getElementById('email').value);
        formData.append('bio', document.getElementById('bio').value);

        fetch('./handlers/profile_handler.php?action=update', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(response);
                location.reload();  // Reload the page to show updated profile
            } else {
                alert('Error updating profile: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>
