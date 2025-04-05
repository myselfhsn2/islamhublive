<!-- Forgot Password Page -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4 p-lg-5">
                    <h1 class="h3 text-center mb-4 fw-bold text-primary">Forgot Password</h1>
                    
                    <?php if (isset($_SESSION['flash_error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <?php echo $_SESSION['flash_error']; ?>
                            <?php unset($_SESSION['flash_error']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['flash_message'])): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <?php echo $_SESSION['flash_message']; ?>
                            <?php unset($_SESSION['flash_message']); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center mb-4">Enter your email address and we'll send you a link to reset your password.</p>
                    <?php endif; ?>
                    
                    <form method="POST" action="<?php echo BASE_URL; ?>/auth/forgot-password" class="needs-validation" novalidate>
                        <div class="mb-4">
                            <label for="email" class="form-label fw-medium">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope text-primary"></i>
                                </span>
                                <input type="email" class="form-control form-control-lg" id="email" name="email" required>
                            </div>
                            <div class="invalid-feedback">Please enter your email address</div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg py-3 fw-medium">
                                <i class="fas fa-paper-plane me-2"></i> Send Reset Link
                            </button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p>Remember your password? <a href="<?php echo BASE_URL; ?>/auth/login" class="text-primary fw-bold">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Form validation
    const form = document.querySelector('form.needs-validation');
    
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        form.classList.add('was-validated');
    });
});
</script> 