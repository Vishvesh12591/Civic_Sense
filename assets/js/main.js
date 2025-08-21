// Main JavaScript file for Civic Sense application

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initializeTooltips();
    initializePopovers();
    initializeSmoothScrolling();
    initializeFormValidation();
    initializeAutoHideAlerts();
    initializeLikeButtons();
    initializeSearchFilters();
    initializeModalHandlers();
});

// Initialize Bootstrap tooltips
function initializeTooltips() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// Initialize Bootstrap popovers
function initializePopovers() {
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
}

// Smooth scrolling for anchor links
function initializeSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Form validation
function initializeFormValidation() {
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!this.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            this.classList.add('was-validated');
        });
    });
}

// Auto-hide alerts after 5 seconds
function initializeAutoHideAlerts() {
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
}

// Initialize like buttons functionality
function initializeLikeButtons() {
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.getAttribute('data-post-id');
            const likeText = this.querySelector('.like-text');
            const isLiked = this.getAttribute('data-liked') === 'true';
            
            // Toggle like state visually
            if (isLiked) {
                this.setAttribute('data-liked', 'false');
                likeText.textContent = 'Like';
                this.classList.remove('btn-danger');
                this.classList.add('btn-outline-danger');
            } else {
                this.setAttribute('data-liked', 'true');
                likeText.textContent = 'Unlike';
                this.classList.add('btn-danger');
                this.classList.remove('btn-outline-danger');
            }
            
            // Send AJAX request to update like count
            updateLikeCount(postId);
        });
    });
}

// Update like count via AJAX
function updateLikeCount(postId) {
    fetch('?page=forum', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'ajax_like=1&post_id=' + postId
    })
    .then(response => response.json())
    .then(data => {
        // Update like count display if needed
        console.log('Like updated:', data);
    })
    .catch(error => {
        console.error('Error updating like:', error);
    });
}

// Initialize search filters
function initializeSearchFilters() {
    const searchInputs = document.querySelectorAll('input[name="search"]');
    const categorySelects = document.querySelectorAll('select[name="category"]');
    
    // Auto-submit form when category changes
    categorySelects.forEach(select => {
        select.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
    
    // Debounced search for better performance
    searchInputs.forEach(input => {
        let timeout;
        input.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                this.closest('form').submit();
            }, 500);
        });
    });
}

// Initialize modal handlers
function initializeModalHandlers() {
    // Handle dynamic content in modals
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            if (button) {
                // Handle data attributes for dynamic content
                const postId = button.getAttribute('data-post-id');
                const problemId = button.getAttribute('data-problem-id');
                
                if (postId) {
                    const modalPostId = modal.querySelector('#modalPostId');
                    if (modalPostId) modalPostId.value = postId;
                }
                
                if (problemId) {
                    const modalProblemId = modal.querySelector('#modalProblemId');
                    if (modalProblemId) modalProblemId.value = problemId;
                }
            }
        });
    });
}

// Utility functions
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// Handle AJAX form submissions
function submitFormAjax(form, successCallback = null, errorCallback = null) {
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: form.method,
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (successCallback) successCallback(data);
            showNotification(data.message || 'Success!', 'success');
        } else {
            if (errorCallback) errorCallback(data);
            showNotification(data.message || 'An error occurred.', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (errorCallback) errorCallback(error);
        showNotification('An error occurred. Please try again.', 'danger');
    });
}

// Initialize character counters for textareas
function initializeCharacterCounters() {
    const textareas = document.querySelectorAll('textarea[data-max-length]');
    textareas.forEach(textarea => {
        const maxLength = parseInt(textarea.getAttribute('data-max-length'));
        const counter = document.createElement('small');
        counter.className = 'form-text text-muted';
        counter.textContent = `0 / ${maxLength} characters`;
        
        textarea.parentNode.appendChild(counter);
        
        textarea.addEventListener('input', function() {
            const currentLength = this.value.length;
            counter.textContent = `${currentLength} / ${maxLength} characters`;
            
            if (currentLength > maxLength) {
                counter.classList.add('text-danger');
            } else {
                counter.classList.remove('text-danger');
            }
        });
    });
}

// Initialize image preview for file inputs
function initializeImagePreviews() {
    const fileInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = input.parentNode.querySelector('.image-preview');
                    if (preview) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    });
}

// Initialize lazy loading for images
function initializeLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}

// Initialize the application
initializeCharacterCounters();
initializeImagePreviews();
initializeLazyLoading();
