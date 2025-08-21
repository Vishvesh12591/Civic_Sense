<?php
// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'report_issue' && isLoggedIn()) {
        $title = sanitizeInput($_POST['title']);
        $description = sanitizeInput($_POST['description']);
        $location = sanitizeInput($_POST['location']);
        $category = sanitizeInput($_POST['category']);
        $priority = sanitizeInput($_POST['priority']);
        
        if (submitIssueReport($title, $description, $location, $category, $priority)) {
            $success_message = "Issue reported successfully!";
        } else {
            $error_message = "Failed to report issue. Please try again.";
        }
    }
}

// Get search and filter parameters
$search = $_GET['search'] ?? '';
$category_filter = $_GET['category'] ?? '';
$problems = getAllProblems($category_filter, $search);
$categories = getProblemCategories();
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="section-title">Report Civic Issues</h1>
            <p class="lead mb-4">Help us identify and address problems in our community. Your reports make a difference!</p>
        </div>
        <div class="col-lg-4 text-lg-end">
            <a href="?page=forum" class="btn btn-outline-primary">
                <i class="fas fa-comments me-2"></i>Join Discussion
            </a>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="?page=problems" class="row g-3">
                <input type="hidden" name="page" value="problems">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search issues..." value="<?php echo htmlspecialchars($search); ?>">
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
                    <a href="?page=problems" class="btn btn-outline-secondary w-100">Clear</a>
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

    <!-- Report Issue Form -->
    <?php if (isLoggedIn()): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-plus-circle me-2"></i>Report New Issue
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="?page=problems">
                    <input type="hidden" name="action" value="report_issue">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="title" class="form-label">Issue Title *</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="col-md-6">
                            <label for="category" class="form-label">Category *</label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $key => $name): ?>
                                    <option value="<?php echo $key; ?>"><?php echo $name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" placeholder="City, Area, or Specific Location">
                        </div>
                        <div class="col-md-6">
                            <label for="priority" class="form-label">Priority</label>
                            <select class="form-select" id="priority" name="priority">
                                <?php foreach (getPriorityLevels() as $key => $name): ?>
                                    <option value="<?php echo $key; ?>"><?php echo $name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required placeholder="Describe the issue in detail..."></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Report Issue
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            <a href="?page=login">Login</a> or <a href="?page=register">Register</a> to report issues and participate in discussions.
        </div>
    <?php endif; ?>

    <!-- Issues List -->
    <div class="row g-4">
        <?php if (empty($problems)): ?>
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5>No issues found</h5>
                    <p class="text-muted"><?php echo $search || $category_filter ? 'Try adjusting your search or filters.' : 'Be the first to report an issue!'; ?></p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($problems as $problem): ?>
                <div class="col-lg-6">
                    <div class="card problem-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title"><?php echo htmlspecialchars($problem['title']); ?></h5>
                                <span class="badge bg-<?php echo $problem['status'] === 'resolved' ? 'success' : ($problem['status'] === 'in_progress' ? 'warning' : 'primary'); ?>">
                                    <?php echo ucfirst(str_replace('_', ' ', $problem['status'])); ?>
                                </span>
                            </div>
                            <p class="card-text"><?php echo htmlspecialchars(substr($problem['description'], 0, 150)) . (strlen($problem['description']) > 150 ? '...' : ''); ?></p>
                            <div class="row text-muted small mb-3">
                                <div class="col-6">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    <?php echo $problem['location'] ?: 'Location not specified'; ?>
                                </div>
                                <div class="col-6">
                                    <i class="fas fa-user me-1"></i>
                                    <?php echo $problem['author_name'] ?: 'Anonymous'; ?>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    <?php echo formatDate($problem['created_at']); ?>
                                </small>
                                <a href="?page=problem-detail&id=<?php echo $problem['id']; ?>" class="btn btn-sm btn-outline-primary">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Pagination would go here if needed -->
</div>
