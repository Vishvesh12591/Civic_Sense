<?php
// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add_solution' && isLoggedIn()) {
        $problem_id = sanitizeInput($_POST['problem_id']);
        $title = sanitizeInput($_POST['title']);
        $description = sanitizeInput($_POST['description']);
        $source = sanitizeInput($_POST['source']);
        
        if (createSolution($problem_id, $title, $description, $source)) {
            $success_message = "Solution added successfully!";
        } else {
            $error_message = "Failed to add solution. Please try again.";
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
            <h1 class="section-title">Solutions & Best Practices</h1>
            <p class="lead mb-4">Discover innovative solutions and learn from successful initiatives around the world.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
            <a href="?page=problems" class="btn btn-outline-primary">
                <i class="fas fa-exclamation-triangle me-2"></i>Report Issues
            </a>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="?page=solutions" class="row g-3">
                <input type="hidden" name="page" value="solutions">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search solutions..." value="<?php echo htmlspecialchars($search); ?>">
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
                    <a href="?page=solutions" class="btn btn-outline-secondary w-100">Clear</a>
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

    <!-- Featured Solutions -->
    <div class="row mb-5">
        <div class="col-12">
            <h3 class="mb-4">
                <i class="fas fa-star text-warning me-2"></i>Featured Solutions
            </h3>
        </div>
        <div class="col-lg-4">
            <div class="card solution-card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-leaf text-success me-2"></i>Sweden's Waste Management
                    </h5>
                    <p class="card-text">Sweden has achieved 99% waste recycling through innovative sorting systems and public education campaigns.</p>
                    <div class="mt-3">
                        <span class="badge bg-success me-2">Environment</span>
                        <span class="badge bg-info">International</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card solution-card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-car text-primary me-2"></i>Singapore's Traffic Management
                    </h5>
                    <p class="card-text">Electronic road pricing and strict enforcement have significantly reduced traffic congestion and pollution.</p>
                    <div class="mt-3">
                        <span class="badge bg-primary me-2">Transport</span>
                        <span class="badge bg-info">International</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card solution-card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-graduation-cap text-warning me-2"></i>Finland's Civic Education
                    </h5>
                    <p class="card-text">Comprehensive civic education from early childhood has created a highly engaged and responsible citizenry.</p>
                    <div class="mt-3">
                        <span class="badge bg-warning me-2">Education</span>
                        <span class="badge bg-info">International</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Problems and Solutions -->
    <div class="row g-4">
        <?php if (empty($problems)): ?>
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-lightbulb fa-3x text-muted mb-3"></i>
                    <h5>No problems found</h5>
                    <p class="text-muted"><?php echo $search || $category_filter ? 'Try adjusting your search or filters.' : 'Be the first to report a problem!'; ?></p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($problems as $problem): ?>
                <div class="col-12">
                    <div class="card problem-card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title"><?php echo htmlspecialchars($problem['title']); ?></h5>
                                        <span class="badge bg-<?php echo $problem['status'] === 'resolved' ? 'success' : ($problem['status'] === 'in_progress' ? 'warning' : 'primary'); ?>">
                                            <?php echo ucfirst(str_replace('_', ' ', $problem['status'])); ?>
                                        </span>
                                    </div>
                                    <p class="card-text"><?php echo htmlspecialchars($problem['description']); ?></p>
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
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        <?php echo formatDate($problem['created_at']); ?>
                                    </small>
                                </div>
                                <div class="col-lg-4">
                                    <h6 class="text-success mb-3">
                                        <i class="fas fa-lightbulb me-2"></i>Solutions
                                    </h6>
                                    <?php
                                    $solutions = getSolutionsByProblemId($problem['id']);
                                    if (empty($solutions)):
                                    ?>
                                        <p class="text-muted small">No solutions yet</p>
                                    <?php else: ?>
                                        <?php foreach (array_slice($solutions, 0, 2) as $solution): ?>
                                            <div class="card solution-card mb-2">
                                                <div class="card-body p-3">
                                                    <h6 class="card-title small"><?php echo htmlspecialchars($solution['title']); ?></h6>
                                                    <p class="card-text small"><?php echo htmlspecialchars(substr($solution['description'], 0, 100)) . (strlen($solution['description']) > 100 ? '...' : ''); ?></p>
                                                    <small class="text-muted">
                                                        <i class="fas fa-user me-1"></i><?php echo $solution['author_name'] ?: 'Anonymous'; ?>
                                                    </small>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                        <?php if (count($solutions) > 2): ?>
                                            <small class="text-muted">+<?php echo count($solutions) - 2; ?> more solutions</small>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
                                    <!-- Add Solution Button -->
                                    <?php if (isLoggedIn()): ?>
                                        <button class="btn btn-sm btn-outline-success w-100 mt-2" data-bs-toggle="modal" data-bs-target="#addSolutionModal" data-problem-id="<?php echo $problem['id']; ?>">
                                            <i class="fas fa-plus me-1"></i>Add Solution
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Add Solution Modal -->
<?php if (isLoggedIn()): ?>
<div class="modal fade" id="addSolutionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-lightbulb me-2"></i>Add Solution
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="?page=solutions">
                <div class="modal-body">
                    <input type="hidden" name="action" value="add_solution">
                    <input type="hidden" name="problem_id" id="modalProblemId">
                    <div class="mb-3">
                        <label for="modalTitle" class="form-label">Solution Title *</label>
                        <input type="text" class="form-control" id="modalTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="modalDescription" class="form-label">Solution Description *</label>
                        <textarea class="form-control" id="modalDescription" name="description" rows="4" required placeholder="Describe your solution in detail..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="modalSource" class="form-label">Source (Optional)</label>
                        <input type="text" class="form-control" id="modalSource" name="source" placeholder="Where did you learn about this solution?">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Save Solution
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addSolutionModal = document.getElementById('addSolutionModal');
    if (addSolutionModal) {
        addSolutionModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const problemId = button.getAttribute('data-problem-id');
            const modalProblemId = document.getElementById('modalProblemId');
            modalProblemId.value = problemId;
        });
    }
});
</script>
<?php endif; ?>
