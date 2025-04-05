<!-- Reset Password Page -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4 p-lg-5">
                    <h1 class="h3 text-center mb-4 fw-bold text-primary">Reset Password</h1>
                    
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
                    
                    <form method="POST" action="<?php echo BASE_URL; ?>/auth/reset-password" class="needs-validation" novalidate>
                        <input type="hidden" name="token" value="<?php echo $token ?? ''; ?>">
                        
                        <div class="mb-4">
                            <label for="password" class="form-label fw-medium">New Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                                <input type="password" class="form-control form-control-lg" id="password" name="password" required
                                       pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                            <div class="form-text small mt-2">Password must be at least 8 characters and include uppercase, lowercase, and numbers.</div>
                            <div class="invalid-feedback">Please enter a valid password</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="confirm_password" class="form-label fw-medium">Confirm New Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                                <input type="password" class="form-control form-control-lg" id="confirm_password" name="confirm_password" required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback">Passwords don't match</div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg py-3 fw-medium">
                                <i class="fas fa-key me-2"></i> Reset Password
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
    // Toggle password visibility
    const togglePasswordButtons = [
        {button: document.getElementById('togglePassword'), input: document.getElementById('password')},
        {button: document.getElementById('toggleConfirmPassword'), input: document.getElementById('confirm_password')}
    ];
    
    togglePasswordButtons.forEach(item => {
        item.button.addEventListener('click', function () {
            const type = item.input.getAttribute('type') === 'password' ? 'text' : 'password';
            item.input.setAttribute('type', type);
            
            // Toggle the eye icon
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    });
    
    // Password validation
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    
    // Validate password confirmation
    function validatePassword() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity("Passwords don't match");
        } else {
            confirmPassword.setCustomValidity('');
        }
    }
    
    password.addEventListener('input', validatePassword);
    confirmPassword.addEventListener('input', validatePassword);
    
    // Initial validation when page loads
    validatePassword();
    
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