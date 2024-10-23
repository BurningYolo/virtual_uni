<?php
if (!defined('APP_RUNNING')) {
    die('Access denied'); // Stop execution if accessed directly
}
?>

<div class="container-fluid p-4 main-content" id="mainContent">
    <h1>Access Key Generation</h1>

    <?php if ($_SESSION['role'] == "teacher" || $_SESSION['role'] == "university"): ?>
    <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#generateKeyModal" id="generateAccessKeyBtn">
        Generate Access Key
    </button>
    <?php endif; ?>
    


<div class="row">
    <?php if (!empty($accessKeys)): ?>
        <?php foreach ($accessKeys as $key): ?>
            <div class="col-md-12 mb-4">
                <div class="card view_access_keys" style="width: 70%;">
                    <div class="card-header text-white bg-success">
                        <h5 class="mb-0">Access Key: <span class="text-warning"><?php echo htmlspecialchars($key['access_key']); ?></span></h5>
                    </div>
                    <div class="card-body" style=" flex-grow: 1; display: flex;align-items: center;  justify-content: flex-start; ">
                        <div class="view_access_keys-details">
                            <p><strong>Created By:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                            <p><strong>Used By:</strong> <?php echo htmlspecialchars($key['used_by_username'] ?? 'N/A'); ?></p>
                            <p><strong>For Role:</strong> <?php echo htmlspecialchars($key['for_role']); ?></p>
                            <p><strong>Used:</strong> <?php echo htmlspecialchars($key['used'] ? 'Yes' : 'No'); ?></p>
                            <p><strong>Created At:</strong> <?php echo htmlspecialchars($key['created_at']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info" role="alert">No access keys found.</div>
    <?php endif; ?>
</div>

<!-- Modal for generating access key -->
<div class="modal fade" id="generateKeyModal" tabindex="-1" role="dialog" aria-labelledby="generateKeyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="generateKeyModalLabel">Generate Access Key</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Feedback message -->
                <div id="keyFeedback" class="alert d-none" role="alert"></div>

                <form id="generateKeyForm">
                    <h6>Create Access Keys and Invite Students and Teachers to join the platform</h6>
                    <div class="mb-3">
                        
                        <input type="hidden" class="form-control" id="forRole" required>
                    </div>

                    <!-- Hidden fields to store user ID and role -->
                    <input type="hidden" id="userId" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">
                    <input type="hidden" id="userRole" value="<?php echo htmlspecialchars($_SESSION['role']); ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitGenerateKey">Generate Key</button>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('submitGenerateKey').addEventListener('click', function() {
    const feedbackElement = document.getElementById('keyFeedback');
    const forRole = document.getElementById('forRole').value.trim();

    // Clear previous feedback
    feedbackElement.classList.add('d-none');

    // Validate input



    // Get user ID and role from hidden inputs
    const userId = document.getElementById('userId').value; // Get user ID from hidden input
    const userRole = document.getElementById('userRole').value; // Get user role from hidden input

    // Send AJAX request to the handler
    const xhr = new XMLHttpRequest();
    xhr.open('POST', './handlers/access_key_handler.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status === 200) {
            const response = JSON.parse(this.responseText);
            if (response.message === "Access key created successfully.") {
                showFeedback('Access key created successfully!', 'success');
                setTimeout(() => {
                    location.reload(); // Refresh the page after 1 second to show the new key
                }, 1000);
            } else {
                showFeedback('Error: ' + response.message, 'danger');
            }
        } else {
            showFeedback('Error: Unable to process request.', 'danger');
        }
    };

    // Sending the role along with user ID and user role
    xhr.send(`for_role=${encodeURIComponent(forRole)}&user_id=${encodeURIComponent(userId)}&user_role=${encodeURIComponent(userRole)}`);
});

// Function to show feedback in the modal
function showFeedback(message, type) {
    const feedbackElement = document.getElementById('keyFeedback');
    feedbackElement.textContent = message;
    feedbackElement.classList.remove('d-none', 'alert-success', 'alert-danger');
    feedbackElement.classList.add('alert-' + type);
}
</script>

<style>
.view_access_keys {
    border: 2px solid green; /* Bootstrap primary color */
    border-radius: 8px;
}

.view_access_keys-header {
    background-color: #007bff;
    color: #ffffff;
}

.view_access_keys-details {
    line-height: 1.5;
}
</style>

