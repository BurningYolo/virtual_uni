<div class="container-fluid p-4 main-content" id="mainContent">
    <h2 class="mb-4">Discussion Board Posts</h2>

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