<!-- Login Page -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4 p-lg-5">
                    <h1 class="h3 text-center mb-4 fw-bold text-primary">Login to IslamHub</h1>
                    
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
                    <?php endif; ?>
                    
                    <form method="POST" action="<?php echo BASE_URL; ?>/auth/login" class="needs-validation" novalidate>
                        <div class="mb-4">
                            <label for="username" class="form-label fw-medium">Username or Email</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user text-primary"></i>
                                </span>
                                <input type="text" class="form-control form-control-lg" id="username" name="username" required>
                            </div>
                            <div class="invalid-feedback">Please enter your username or email</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="form-label fw-medium">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                                <input type="password" class="form-control form-control-lg" id="password" name="password" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback">Please enter your password</div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                            <a href="<?php echo BASE_URL; ?>/auth/forgot-password" class="text-decoration-none">Forgot Password?</a>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg py-3 fw-medium">
                                <i class="fas fa-sign-in-alt me-2"></i> Login
                            </button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p>Don't have an account? <a href="<?php echo BASE_URL; ?>/auth/register" class="text-primary fw-bold">Register Now</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    
    togglePassword.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Toggle the eye icon
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
    
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