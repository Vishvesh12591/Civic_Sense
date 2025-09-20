<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h1 class="hero-title">Civic Sense: Urgent Need of Society</h1>
                <p class="hero-subtitle">Building a better society through awareness, education, and collective action. Join us in promoting civic responsibility and social consciousness.</p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="?page=problems" class="btn btn-light btn-lg">
                        <i class="fas fa-exclamation-triangle me-2"></i>Report Issues
                    </a>
                    <a href="?page=solutions" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-lightbulb me-2"></i>Find Solutions
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title">Why Civic Sense Matters</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5 class="card-title">Community Building</h5>
                        <p class="card-text">Foster stronger communities through shared responsibility and mutual respect.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <div class="feature-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h5 class="card-title">Environmental Protection</h5>
                        <p class="card-text">Promote sustainable practices and protect our environment for future generations.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <div class="feature-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h5 class="card-title">Education & Awareness</h5>
                        <p class="card-text">Educate citizens about their rights, duties, and responsibilities.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Issues Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title">Key Issues We Address</h2>
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card problem-card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-car text-danger me-2"></i>Road Discipline
                        </h5>
                        <p class="card-text">Traffic violations, reckless driving, and lack of pedestrian safety awareness.</p>
                        <a href="?page=problems&category=road_discipline" class="btn btn-sm btn-outline-primary">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card problem-card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-train text-warning me-2"></i>Transport Infrastructure
                        </h5>
                        <p class="card-text">Poor conditions at railway and bus stations, lack of cleanliness and maintenance.</p>
                        <a href="?page=problems&category=transport_stations" class="btn btn-sm btn-outline-primary">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card problem-card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-user-graduate text-info me-2"></i>Student Behavior
                        </h5>
                        <p class="card-text">Lack of civic sense among students in schools and colleges.</p>
                        <a href="?page=problems&category=student_behavior" class="btn btn-sm btn-outline-primary">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card problem-card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-broom text-success me-2"></i>Cleanliness Issues
                        </h5>
                        <p class="card-text">Lack of cleanliness awareness, potholes, and poor waste management.</p>
                        <a href="?page=problems&category=cleanliness" class="btn btn-sm btn-outline-primary">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h3>Ready to Make a Difference?</h3>
                <p class="lead mb-4">Join our community of responsible citizens and help build a better society.</p>
                <?php if (!isLoggedIn()): ?>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="?page=register" class="btn btn-primary btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Join Now
                        </a>
                        <a href="?page=forum" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-comments me-2"></i>Join Discussion
                        </a>
                    </div>
                <?php else: ?>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="?page=forum" class="btn btn-primary btn-lg">
                            <i class="fas fa-comments me-2"></i>Join Discussion
                        </a>
                        <a href="?page=problems" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-exclamation-triangle me-2"></i>Report Issue
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3">
                <div class="mb-3">
                    <i class="fas fa-users fa-3x mb-3"></i>
                    <h4>100+</h4>
                    <p>Active Members</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                    <h4>50+</h4>
                    <p>Issues Reported</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <i class="fas fa-lightbulb fa-3x mb-3"></i>
                    <h4>NO+</h4>
                    <p>Solutions Shared</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <i class="fas fa-check-circle fa-3x mb-3"></i>
                    <h4>200+</h4>
                    <p>Issues Resolved</p>
                </div>
            </div>
        </div>
    </div>
</section>

