<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/User.php';

/**
 * Auth Controller
 * 
 * Handles user authentication functionality
 */
class AuthController extends Controller {
    private $userModel;
    
    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
        
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Display login form
     */
    public function login() {
        // Redirect if already logged in
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/dashboard');
            return;
        }
        
        $this->render('auth/login', [
            'title' => 'Login - IslamHub'
        ]);
    }
    
    /**
     * Process login form submission
     */
    public function processLogin() {
        $username = $this->post('username');
        $password = $this->post('password');
        $remember = $this->post('remember') ? true : false;
        
        if (empty($username) || empty($password)) {
            $_SESSION['flash_error'] = 'All fields are required';
            $this->redirect('/auth/login');
            return;
        }
        
        $user = $this->userModel->login($username, $password);
        
        if ($user) {
            // Set user session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['preferences'] = $user['preferences'] ?? [];
            
            // Set remember me cookie if requested
            if ($remember) {
                $token = bin2hex(random_bytes(32));
                $expires = time() + (30 * 24 * 60 * 60); // 30 days
                
                // Store token in database
                $this->userModel->storeRememberToken($user['id'], $token, $expires);
                
                // Set secure cookie
                setcookie('remember_token', $token, $expires, '/', '', false, true);
            }
            
            // Check if there's a redirect after login
            if (isset($_SESSION['redirect_after_login'])) {
                $redirect = $_SESSION['redirect_after_login'];
                unset($_SESSION['redirect_after_login']);
                $this->redirect($redirect);
            } else {
                $this->redirect('/dashboard');
            }
        } else {
            $_SESSION['flash_error'] = 'Invalid username or password';
            $this->redirect('/auth/login');
        }
    }
    
    /**
     * Display registration form
     */
    public function register() {
        // Redirect if already logged in
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/dashboard');
            return;
        }
        
        $this->render('auth/register', [
            'title' => 'Register - IslamHub'
        ]);
    }
    
    /**
     * Process registration form submission
     */
    public function processRegistration() {
        $userData = [
            'username' => trim($this->post('username')),
            'email' => trim($this->post('email')),
            'password' => $this->post('password'),
            'password_confirm' => $this->post('password_confirm'),
            'full_name' => trim($this->post('full_name')),
            'phone_number' => trim($this->post('phone_number'))
        ];
        
        // Check if terms are accepted
        if (!$this->post('terms')) {
            $_SESSION['flash_error'] = 'You must agree to the Terms of Service and Privacy Policy';
            $_SESSION['form_data'] = $userData;
            $this->redirect('/auth/register');
            return;
        }
        
        // Validate required fields
        if (empty($userData['username']) || empty($userData['email']) || 
            empty($userData['password']) || empty($userData['full_name'])) {
            $_SESSION['flash_error'] = 'All required fields must be filled out';
            $_SESSION['form_data'] = $userData;
            $this->redirect('/auth/register');
            return;
        }
        
        // Validate email format
        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash_error'] = 'Please enter a valid email address';
            $_SESSION['form_data'] = $userData;
            $this->redirect('/auth/register');
            return;
        }
        
        // Validate password strength
        $password_pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/";
        if (!preg_match($password_pattern, $userData['password'])) {
            $_SESSION['flash_error'] = 'Password must be at least 8 characters and include uppercase, lowercase, and numbers';
            $_SESSION['form_data'] = $userData;
            $this->redirect('/auth/register');
            return;
        }
        
        // Validate password match
        if ($userData['password'] !== $userData['password_confirm']) {
            $_SESSION['flash_error'] = 'Passwords do not match';
            $_SESSION['form_data'] = $userData;
            $this->redirect('/auth/register');
            return;
        }
        
        // Remove password_confirm from userData
        unset($userData['password_confirm']);
        
        // Set default preferences (including dark mode)
        $userData['preferences'] = [
            'dark_mode' => false,
            'email_notifications' => true
        ];
        
        $result = $this->userModel->register($userData);
        
        if ($result === true) {
            $_SESSION['flash_message'] = 'Registration successful! Please log in.';
            $this->redirect('/auth/login');
        } else {
            $_SESSION['flash_error'] = $result;
            $_SESSION['form_data'] = $userData;
            $this->redirect('/auth/register');
        }
    }
    
    /**
     * Process user logout
     */
    public function logout() {
        // Remove remember me cookie if exists
        if (isset($_COOKIE['remember_token'])) {
            // Remove from database
            $this->userModel->removeRememberToken($_COOKIE['remember_token']);
            
            // Expire cookie
            setcookie('remember_token', '', time() - 3600, '/');
        }
        
        // Unset all session variables
        $_SESSION = [];
        
        // Destroy the session
        session_destroy();
        
        $this->redirect('/');
    }
    
    /**
     * Toggle dark mode preference
     */
    public function toggleDarkMode() {
        if (!isset($_SESSION['user_id']) || !$this->isAjax()) {
            $this->json(['success' => false, 'message' => 'Unauthorized'], 401);
            return;
        }
        
        // Get current preference
        $currentMode = $_SESSION['preferences']['dark_mode'] ?? false;
        
        // Toggle the preference
        $newPreferences = ['dark_mode' => !$currentMode];
        
        $result = $this->userModel->updatePreferences($_SESSION['user_id'], $newPreferences);
        
        if ($result) {
            // Update session
            if (!isset($_SESSION['preferences'])) {
                $_SESSION['preferences'] = [];
            }
            $_SESSION['preferences']['dark_mode'] = !$currentMode;
            
            $this->json([
                'success' => true,
                'dark_mode' => !$currentMode
            ]);
        } else {
            $this->json(['success' => false, 'message' => 'Failed to update preference'], 500);
        }
    }
    
    /**
     * Display forgot password form
     */
    public function forgotPassword() {
        $this->render('auth/forgot_password', [
            'title' => 'Forgot Password - IslamHub'
        ]);
    }
    
    /**
     * Process forgot password request
     */
    public function processForgotPassword() {
        $email = trim($this->post('email'));
        
        if (empty($email)) {
            $_SESSION['flash_error'] = 'Please enter your email address';
            $this->redirect('/auth/forgot-password');
            return;
        }
        
        $result = $this->userModel->generatePasswordResetToken($email);
        
        if ($result === true) {
            $_SESSION['flash_message'] = 'Password reset instructions have been sent to your email';
        } else {
            $_SESSION['flash_error'] = $result;
        }
        
        $this->redirect('/auth/forgot-password');
    }
    
    /**
     * Display reset password form
     */
    public function resetPassword($token) {
        if (empty($token)) {
            $_SESSION['flash_error'] = 'Invalid reset token';
            $this->redirect('/auth/forgot-password');
            return;
        }
        
        // Verify token exists and is not expired
        $tokenValid = $this->userModel->verifyResetToken($token);
        
        if (!$tokenValid) {
            $_SESSION['flash_error'] = 'Invalid or expired reset token. Please request a new password reset.';
            $this->redirect('/auth/forgot-password');
            return;
        }
        
        $this->render('auth/reset_password', [
            'title' => 'Reset Password - IslamHub',
            'token' => $token
        ]);
    }
    
    /**
     * Process reset password request
     */
    public function processResetPassword() {
        $token = $this->post('token');
        $password = $this->post('password');
        $confirmPassword = $this->post('confirm_password');
        
        if (empty($token) || empty($password) || empty($confirmPassword)) {
            $_SESSION['flash_error'] = 'All fields are required';
            $this->redirect('/auth/reset-password/' . $token);
            return;
        }
        
        // Validate password strength
        $password_pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/";
        if (!preg_match($password_pattern, $password)) {
            $_SESSION['flash_error'] = 'Password must be at least 8 characters and include uppercase, lowercase, and numbers';
            $this->redirect('/auth/reset-password/' . $token);
            return;
        }
        
        // Validate password match
        if ($password !== $confirmPassword) {
            $_SESSION['flash_error'] = 'Passwords do not match';
            $this->redirect('/auth/reset-password/' . $token);
            return;
        }
        
        $result = $this->userModel->resetPassword($token, $password);
        
        if ($result === true) {
            $_SESSION['flash_message'] = 'Password has been reset successfully. You can now login with your new password.';
            $this->redirect('/auth/login');
        } else {
            $_SESSION['flash_error'] = $result;
            $this->redirect('/auth/reset-password/' . $token);
        }
    }
    
    /**
     * Check for remember me cookie and auto-login
     */
    public function checkRememberMe() {
        if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
            $token = $_COOKIE['remember_token'];
            $user = $this->userModel->getUserByRememberToken($token);
            
            if ($user) {
                // Set user session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['preferences'] = $user['preferences'];
                
                // Refresh token
                $newToken = bin2hex(random_bytes(32));
                $expires = time() + (30 * 24 * 60 * 60); // 30 days
                
                // Update token in database
                $this->userModel->updateRememberToken($token, $newToken, $expires);
                
                // Set new cookie
                setcookie('remember_token', $newToken, $expires, '/', '', true, true);
            }
        }
    }
} 