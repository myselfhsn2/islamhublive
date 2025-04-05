<?php
// This is a direct login script to bypass routing issues

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

// Define base URL constant if not already defined
if (!defined('BASE_URL')) {
    // Determine if using built-in server or Apache
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    
    // Check if running in a subdirectory
    $script_name = dirname($_SERVER['SCRIPT_NAME']);
    $base_path = $script_name !== '/' ? rtrim($script_name, '/') : '';
    
    define('BASE_URL', $protocol . '://' . $host . $base_path);
}

// Include necessary files
require_once __DIR__ . '/includes/Database.php';

// Connect to database
$db = Database::getInstance();
$conn = $db->getConnection();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (!empty($username) && !empty($password)) {
        // Check if input is email or username
        $field = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        // Prepare query
        $query = "
            SELECT id, username, email, password, full_name, preferences
            FROM users
            WHERE $field = ? AND is_active = TRUE
        ";
        
        // Execute query with parameter
        $stmt = $db->query($query, [$username]);
        $user = $db->fetch($stmt);
        
        if (!$user) {
            $error = "Invalid username or password";
        } else {
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set user session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];
                
                if (!empty($user['preferences'])) {
                    $_SESSION['preferences'] = json_decode($user['preferences'], true);
                } else {
                    $_SESSION['preferences'] = [];
                }
                
                $success = "Login successful! You are now logged in as " . $user['username'];
                
                // Redirect to homepage after successful login
                header("Refresh: 2; URL=" . BASE_URL . "/");
            } else {
                $error = "Invalid username or password";
            }
        }
    } else {
        $error = "All fields are required";
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="<?php echo isset($_SESSION['preferences']['dark_mode']) && $_SESSION['preferences']['dark_mode'] ? 'dark' : 'light'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direct Login - IslamHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-4 p-lg-5">
                        <h1 class="h3 text-center mb-4 fw-bold text-primary">Direct Login to IslamHub</h1>
                        
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($success)): ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                <?php echo $success; ?>
                            </div>
                            <div class="text-center mt-4">
                                <p>You are now logged in!</p>
                                <p><a href="<?php echo BASE_URL; ?>/" class="btn btn-primary">Go to Homepage</a></p>
                            </div>
                        <?php else: ?>
                            <form method="POST" action="direct_login.php" class="needs-validation" novalidate>
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
                                
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg py-3 fw-medium">
                                        <i class="fas fa-sign-in-alt me-2"></i> Login
                                    </button>
                                </div>
                            </form>
                            
                            <div class="text-center mt-4">
                                <p>Use credentials: testuser / Password123</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle the eye icon
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        }
        
        // Form validation
        const form = document.querySelector('form.needs-validation');
        
        if (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                
                form.classList.add('was-validated');
            });
        }
        
        // Check for saved dark mode preference
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.setAttribute('data-bs-theme', 'dark');
        } else if (localStorage.getItem('darkMode') === 'false') {
            document.documentElement.setAttribute('data-bs-theme', 'light');
        }
    });
    </script>
</body>
</html> 