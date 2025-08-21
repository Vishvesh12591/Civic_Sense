<?php
// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'contact_form') {
        $name = sanitizeInput($_POST['name']);
        $email = sanitizeInput($_POST['email']);
        $subject = sanitizeInput($_POST['subject']);
        $message = sanitizeInput($_POST['message']);
        
        if (submitContact($name, $email, $subject, $message)) {
            $success_message = "Your message has been sent successfully! We'll get back to you soon.";
        } else {
            $error_message = "Failed to send message. Please try again.";
        }
    } elseif ($_POST['action'] === 'report_issue' && isLoggedIn()) {
        $title = sanitizeInput($_POST['title']);
        $description = sanitizeInput($_POST['description']);
        $location = sanitizeInput($_POST['location']);
        $category = sanitizeInput($_POST['category']);
        $priority = sanitizeInput($_POST['priority']);
        
        if (submitIssueReport($title, $description, $location, $category, $priority)) {
            $success_message = "Issue reported successfully! We'll review and take appropriate action.";
        } else {
            $error_message = "Failed to report issue. Please try again.";
        }
    }
}

$categories = getProblemCategories();
$priorities = getPriorityLevels();
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="section-title">Contact Us</h1>
            <p class="lead mb-4">Have questions, suggestions, or need to report an issue? We'd love to hear from you!</p>
        </div>
        <div class="col-lg-4 text-lg-end">
            <a href="?page=forum" class="btn btn-outline-primary">
                <i class="fas fa-comments me-2"></i>Join Discussion
            </a>
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

    <div class="row g-5">
        <!-- Contact Information -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-info-circle text-primary me-2"></i>Get in Touch
                    </h5>
                    
                    <div class="mb-4">
                        <h6><i class="fas fa-map-marker-alt text-danger me-2"></i>Address</h6>
                        <p class="text-muted">123 Civic Center Drive<br>Community Plaza, Suite 100<br>City, State 12345</p>
                    </div>
                    
                    <div class="mb-4">
                        <h6><i class="fas fa-phone text-success me-2"></i>Phone</h6>
                        <p class="text-muted">+1 (555) 123-4567<br>+1 (555) 987-6543</p>
                    </div>
                    
                    <div class="mb-4">
                        <h6><i class="fas fa-envelope text-info me-2"></i>Email</h6>
                        <p class="text-muted">info@civicsense.org<br>support@civicsense.org</p>
                    </div>
                    
                    <div class="mb-4">
                        <h6><i class="fas fa-clock text-warning me-2"></i>Office Hours</h6>
                        <p class="text-muted">Monday - Friday: 9:00 AM - 6:00 PM<br>Saturday: 10:00 AM - 2:00 PM<br>Sunday: Closed</p>
                    </div>
                    
                    <div class="mb-4">
                        <h6><i class="fas fa-share-alt text-primary me-2"></i>Follow Us</h6>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-outline-primary btn-sm">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="#" class="btn btn-outline-info btn-sm">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-outline-danger btn-sm">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary btn-sm">
                                <i class="fab fa-linkedin"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-envelope me-2"></i>Send us a Message
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="?page=contact">
                        <input type="hidden" name="action" value="contact_form">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label">Subject *</label>
                                <input type="text" class="form-control" id="subject" name="subject" required>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">Message *</label>
                                <textarea class="form-control" id="message" name="message" rows="5" required placeholder="Tell us what's on your mind..."></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Issue Reporting Section -->
    <?php if (isLoggedIn()): ?>
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-exclamation-triangle text-warning me-2"></i>Report an Issue
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-4">Found a civic issue that needs attention? Report it here and we'll help get it resolved.</p>
                        
                        <form method="POST" action="?page=contact">
                            <input type="hidden" name="action" value="report_issue">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="issueTitle" class="form-label">Issue Title *</label>
                                    <input type="text" class="form-control" id="issueTitle" name="title" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="issueCategory" class="form-label">Category *</label>
                                    <select class="form-select" id="issueCategory" name="category" required>
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $key => $name): ?>
                                            <option value="<?php echo $key; ?>"><?php echo $name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="issueLocation" class="form-label">Location</label>
                                    <input type="text" class="form-control" id="issueLocation" name="location" placeholder="City, Area, or Specific Location">
                                </div>
                                <div class="col-md-6">
                                    <label for="issuePriority" class="form-label">Priority</label>
                                    <select class="form-select" id="issuePriority" name="priority">
                                        <?php foreach ($priorities as $key => $name): ?>
                                            <option value="<?php echo $key; ?>"><?php echo $name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="issueDescription" class="form-label">Issue Description *</label>
                                    <textarea class="form-control" id="issueDescription" name="description" rows="4" required placeholder="Describe the issue in detail, including any relevant information..."></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-flag me-2"></i>Report Issue
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row mt-5">
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <h5>Want to Report Issues?</h5>
                    <p class="mb-3">Login or register to report civic issues and track their progress.</p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="?page=login" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                        <a href="?page=register" class="btn btn-outline-primary">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- FAQ Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h2 class="mb-4">
                <i class="fas fa-question-circle text-primary me-2"></i>Frequently Asked Questions
            </h2>
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            How quickly do you respond to reported issues?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            We typically respond to all reports within 24-48 hours. Urgent issues are prioritized and addressed immediately.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            Can I remain anonymous when reporting issues?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes, you can report issues anonymously. However, providing contact information helps us follow up and provide updates.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            How do you work with local authorities?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            We have established partnerships with local government agencies and work closely with them to ensure issues are properly addressed and resolved.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                            What types of issues can I report?
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            You can report any civic issue including road problems, cleanliness issues, public safety concerns, environmental problems, and more. Visit our Problems page for a complete list of categories.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
