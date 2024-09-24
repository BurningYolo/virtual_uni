<?php
if (!defined('APP_RUNNING')) {
    die('Access denied'); // Stop execution if accessed directly
}

// Your existing code goes here...
?>


<div class="container-fluid p-4 main-content" id="mainContent">
    <h2 class="mb-4">Discussion Board Posts</h2>
    <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#postModal">
        Create New Post
    </button>

    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="view_posts-bubble mb-4">
                <div class="view_posts-bubble-header d-flex align-items-center">
                    <img src="<?= htmlspecialchars($post['profile_picture']); ?>" 
                         alt="Profile Picture" class="view_posts-profile-picture">
                    <div class="view_posts-username ml-3">
                        <strong><?= htmlspecialchars($post['username']); ?></strong>
                        <p class="view_posts-time text-muted mb-1">
                            Posted on <?= date("F j, Y, g:i a", strtotime($post['created_at'])); ?>
                        </p>
                    </div>
                </div>
                <div class="view_posts-bubble-content">
                    <p class="view_posts-text"><?= nl2br(htmlspecialchars($post['content'])); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info" role="alert">
            No posts available for this discussion board.
        </div>
    <?php endif; ?>
</div>

<!-- Modal for creating a post -->
<div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="postModalLabel">Create a New Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Feedback message -->
        <div id="postFeedback" class="alert d-none" role="alert"></div>

        <form id="createPostForm">
          <div class="form-group">
            <label for="postContent">Post Content</label>
            <textarea class="form-control" id="postContent" rows="4" required></textarea>
          </div>
          <input type="hidden" id="boardId" value="<?= htmlspecialchars($board_id); ?>">
          <input type="hidden" id="userId" value="<?php echo $_SESSION['user_id'] ?>">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submitPost">Post</button>
      </div>
    </div>
  </div>
</div>

<script>
    document.getElementById('submitPost').addEventListener('click', function() {
        const postContent = document.getElementById('postContent').value;
        const boardId = document.getElementById('boardId').value;
        const userId = document.getElementById('userId').value;

        const feedbackElement = document.getElementById('postFeedback');

        if (postContent.trim() === "") {
            showFeedback('Post content cannot be empty.', 'danger');
            return;
        }

        // Send AJAX request to the PHP handler
        const xhr = new XMLHttpRequest();
        xhr.open('POST', './handlers/posts_handler.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (this.status === 200) {
                const response = JSON.parse(this.responseText);
                if (response.message === "Post created successfully.") {
                    
                    setTimeout(() => {
                        showFeedback('Post created successfully!', 'success');
                        location.reload(); // Refresh the page after 1 second to show the new post
                    }, 1000);
                } else {
                    showFeedback('Error: ' + response.message, 'danger');
                }
            }
        };

        xhr.send(`board_id=${boardId}&user_id=${userId}&content=${encodeURIComponent(postContent)}`);
    });

    // Function to show feedback in the modal
    function showFeedback(message, type) {
        const feedbackElement = document.getElementById('postFeedback');
        feedbackElement.textContent = message;
        feedbackElement.classList.remove('d-none', 'alert-success', 'alert-danger');
        feedbackElement.classList.add('alert-' + type);
    }
</script>