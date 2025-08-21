<?php
// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'create_post' && isLoggedIn()) {
        $title = sanitizeInput($_POST['title']);
        $content = sanitizeInput($_POST['content']);
        $category = sanitizeInput($_POST['category']);
        
        if (createForumPost($title, $content, $category)) {
            $success_message = "Post created successfully!";
        } else {
            $error_message = "Failed to create post. Please try again.";
        }
    } elseif ($_POST['action'] === 'add_comment' && isLoggedIn()) {
        $post_id = sanitizeInput($_POST['post_id']);
        $content = sanitizeInput($_POST['content']);
        
        if (createComment($post_id, $content)) {
            $success_message = "Comment added successfully!";
        } else {
            $error_message = "Failed to add comment. Please try again.";
        }
    }
}

// Handle AJAX requests for likes
if (isset($_POST['ajax_like']) && isLoggedIn()) {
    $post_id = (int)$_POST['post_id'];
    $result = toggleLike($post_id);
    echo json_encode(['status' => $result]);
    exit;
}

// Get search and filter parameters
$search = $_GET['search'] ?? '';
$category_filter = $_GET['category'] ?? '';
$posts = getAllForumPosts($category_filter, $search);
$categories = getProblemCategories();
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="section-title">Community Forum</h1>
            <p class="lead mb-4">Join the discussion! Share your thoughts, ask questions, and learn from other community members.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
            <?php if (isLoggedIn()): ?>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPostModal">
                    <i class="fas fa-plus me-2"></i>Create Post
                </button>
            <?php else: ?>
                <a href="?page=login" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt me-2"></i>Login to Post
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="?page=forum" class="row g-3">
                <input type="hidden" name="page" value="forum">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search posts..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $key => $name): ?>
                            <option value="<?php echo $key; ?>" <?php echo $category_filter === $key ? 'selected' : ''; ?>>
                                <?php echo $name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Search
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="?page=forum" class="btn btn-outline-secondary w-100">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Alerts -->
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?php echo $success_message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?php echo $error_message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Forum Posts -->
    <div class="row g-4">
        <?php if (empty($posts)): ?>
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                    <h5>No posts found</h5>
                    <p class="text-muted"><?php echo $search || $category_filter ? 'Try adjusting your search or filters.' : 'Be the first to start a discussion!'; ?></p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <div class="col-12">
                    <div class="card forum-post">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h5 class="card-title">
                                        <a href="?page=post-detail&id=<?php echo $post['id']; ?>" class="text-decoration-none">
                                            <?php echo htmlspecialchars($post['title']); ?>
                                        </a>
                                    </h5>
                                    <p class="card-text"><?php echo htmlspecialchars(substr($post['content'], 0, 200)) . (strlen($post['content']) > 200 ? '...' : ''); ?></p>
                                    <div class="row text-muted small mb-3">
                                        <div class="col-6">
                                            <i class="fas fa-user me-1"></i>
                                            <?php echo $post['author_name'] ?: 'Anonymous'; ?>
                                        </div>
                                        <div class="col-6">
                                            <i class="fas fa-calendar me-1"></i>
                                            <?php echo formatDate($post['created_at']); ?>
                                        </div>
                                    </div>
                                    <?php if ($post['category']): ?>
                                        <span class="badge bg-secondary"><?php echo $categories[$post['category']] ?? $post['category']; ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="text-center">
                                            <i class="fas fa-comments text-primary"></i>
                                            <div class="small"><?php echo $post['comment_count']; ?> Comments</div>
                                        </div>
                                        <div class="text-center">
                                            <i class="fas fa-heart text-danger"></i>
                                            <div class="small"><?php echo $post['like_count']; ?> Likes</div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <a href="?page=post-detail&id=<?php echo $post['id']; ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>View Discussion
                                        </a>
                                        <?php if (isLoggedIn()): ?>
                                            <button class="btn btn-sm btn-outline-danger like-btn" data-post-id="<?php echo $post['id']; ?>" data-liked="<?php echo isLikedByUser($post['id']) ? 'true' : 'false'; ?>">
                                                <i class="fas fa-heart me-1"></i>
                                                <span class="like-text"><?php echo isLikedByUser($post['id']) ? 'Unlike' : 'Like'; ?></span>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Create Post Modal -->
<?php if (isLoggedIn()): ?>
<div class="modal fade" id="createPostModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Create New Post
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="?page=forum">
                <div class="modal-body">
                    <input type="hidden" name="action" value="create_post">
                    <div class="mb-3">
                        <label for="postTitle" class="form-label">Post Title *</label>
                        <input type="text" class="form-control" id="postTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="postCategory" class="form-label">Category</label>
                        <select class="form-select" id="postCategory" name="category">
                            <option value="">Select Category (Optional)</option>
                            <?php foreach ($categories as $key => $name): ?>
                                <option value="<?php echo $key; ?>"><?php echo $name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="postContent" class="form-label">Post Content *</label>
                        <textarea class="form-control" id="postContent" name="content" rows="6" required placeholder="Share your thoughts, questions, or ideas..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Create Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle like buttons
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.getAttribute('data-post-id');
            const likeText = this.querySelector('.like-text');
            const isLiked = this.getAttribute('data-liked') === 'true';
            
            // Send AJAX request
            fetch('?page=forum', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'ajax_like=1&post_id=' + postId
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'liked') {
                    this.setAttribute('data-liked', 'true');
                    likeText.textContent = 'Unlike';
                    this.classList.add('btn-danger');
                    this.classList.remove('btn-outline-danger');
                } else {
                    this.setAttribute('data-liked', 'false');
                    likeText.textContent = 'Like';
                    this.classList.remove('btn-danger');
                    this.classList.add('btn-outline-danger');
                }
                
                // Update like count (you might want to refresh the page or update the count dynamically)
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
</script>
