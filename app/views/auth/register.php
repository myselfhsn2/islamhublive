<!-- Register Page -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4 p-lg-5">
                    <h1 class="h3 text-center mb-4 fw-bold text-primary">Create an Account</h1>
                    
                    <?php if (isset($_SESSION['flash_error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <?php echo $_SESSION['flash_error']; ?>
                            <?php unset($_SESSION['flash_error']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="<?php echo BASE_URL; ?>/auth/register" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="full_name" class="form-label fw-medium">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user text-primary"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-lg" id="full_name" name="full_name" value="<?php echo isset($_SESSION['form_data']['full_name']) ? $_SESSION['form_data']['full_name'] : ''; ?>" required>
                                </div>
                                <div class="invalid-feedback">Please enter your full name</div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <label for="username" class="form-label fw-medium">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-at text-primary"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-lg" id="username" name="username" value="<?php echo isset($_SESSION['form_data']['username']) ? $_SESSION['form_data']['username'] : ''; ?>" required>
                                </div>
                                <div class="invalid-feedback">Please choose a username</div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="email" class="form-label fw-medium">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope text-primary"></i>
                                    </span>
                                    <input type="email" class="form-control form-control-lg" id="email" name="email" value="<?php echo isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : ''; ?>" required>
                                </div>
                                <div class="invalid-feedback">Please enter a valid email address</div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <label for="phone_number" class="form-label fw-medium">Phone Number (Optional)</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-phone text-primary"></i>
                                    </span>
                                    <input type="tel" class="form-control form-control-lg" id="phone_number" name="phone_number" value="<?php echo isset($_SESSION['form_data']['phone_number']) ? $_SESSION['form_data']['phone_number'] : ''; ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="password" class="form-label fw-medium">Password</label>
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
                            
                            <div class="col-md-6 mb-4">
                                <label for="confirm_password" class="form-label fw-medium">Confirm Password</label>
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
                        </div>
                        
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms of Service</a> and <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">Privacy Policy</a>
                                </label>
                                <div class="invalid-feedback">You must agree to our terms and conditions</div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg py-3 fw-medium">
                                <i class="fas fa-user-plus me-2"></i> Register
                            </button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p>Already have an account? <a href="<?php echo BASE_URL; ?>/auth/login" class="text-primary fw-bold">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms of Service Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Terms of Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>1. Acceptance of Terms</h5>
                <p>By accessing and using IslamHub, you agree to be bound by these Terms of Service.</p>
                
                <h5>2. User Accounts</h5>
                <p>You are responsible for maintaining the confidentiality of your account credentials and for all activities under your account.</p>
                
                <h5>3. User Conduct</h5>
                <p>You agree to use our services in accordance with all applicable laws and regulations.</p>
                
                <h5>4. Course Content</h5>
                <p>All course content is provided for educational purposes only. You may not reproduce, distribute, or create derivative works without permission.</p>
                
                <h5>5. Modifications</h5>
                <p>We reserve the right to modify these terms at any time. Your continued use of the service constitutes acceptance of the updated terms.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">I Understand</button>
            </div>
        </div>
    </div>
</div>

<!-- Privacy Policy Modal -->
<div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="privacyModalLabel">Privacy Policy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>1. Information Collection</h5>
                <p>We collect personal information you provide when creating an account or enrolling in courses.</p>
                
                <h5>2. Use of Information</h5>
                <p>We use your information to provide and improve our services, communicate with you, and track your course progress.</p>
                
                <h5>3. Data Security</h5>
                <p>We implement appropriate security measures to protect your personal information.</p>
                
                <h5>4. Cookies</h5>
                <p>We use cookies to enhance your experience on our website.</p>
                
                <h5>5. Third-Party Services</h5>
                <p>We may use third-party services to process payments and analyze user behavior.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">I Understand</button>
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
    
    <?php if (isset($_SESSION['form_data'])): ?>
        // Clear form data after loading
        <?php unset($_SESSION['form_data']); ?>
    <?php endif; ?>
});
</script> 