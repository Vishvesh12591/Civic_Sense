<?php
// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];
    
    if (loginUser($username, $password)) {
        header('Location: ?page=home');
        exit();
    } else {
        $error_message = "Invalid username/email or password. Please try again.";
    }
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h3 class="mb-0">
                        <i class="fas fa-sign-in-alt text-primary me-2"></i>Login
                    </h3>
                    <p class="text-muted mb-0">Welcome back! Please login to your account.</p>
                </div>
                <div class="card-body">
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i><?php echo $error_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="?page=login">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username or Email *</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" class="form-control" id="username" name="username" required placeholder="Enter your username or email">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password *</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control" id="password" name="password" required placeholder="Enter your password">
                            </div>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>
                        </div>
                    </form>
                    
                    <hr class="my-4">
                    
                    <div class="text-center">
                        <p class="mb-2">Don't have an account?</p>
                        <a href="?page=register" class="btn btn-outline-primary">
                            <i class="fas fa-user-plus me-2"></i>Create Account
                        </a>
                    </div>
                    
                    <div class="text-center mt-3">
                        <a href="#" class="text-muted small">
                            <i class="fas fa-question-circle me-1"></i>Forgot your password?
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Additional Information -->
            <div class="card mt-4">
                <div class="card-body text-center">
                    <h6 class="card-title">
                        <i class="fas fa-info-circle text-info me-2"></i>Why Login?
                    </h6>
                    <div class="row g-3 mt-3">
                        <div class="col-6">
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle text-warning fa-2x mb-2"></i>
                                <p class="small mb-0">Report Issues</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <i class="fas fa-comments text-primary fa-2x mb-2"></i>
                                <p class="small mb-0">Join Discussions</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <i class="fas fa-lightbulb text-success fa-2x mb-2"></i>
                                <p class="small mb-0">Share Solutions</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <i class="fas fa-heart text-danger fa-2x mb-2"></i>
                                <p class="small mb-0">Like & Comment</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
