<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Course.php';

/**
 * Dashboard Controller
 * 
 * Handles user dashboard functionality
 */
class DashboardController extends Controller {
    private $userModel;
    private $courseModel;
    
    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
        $this->courseModel = new Course();
        
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }
    }
    
    /**
     * Display the main dashboard
     */
    public function index() {
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->getById($userId);
        $userCourses = $this->courseModel->getUserCourses($userId);
        
        $this->render('dashboard/index', [
            'title' => 'Dashboard - IslamHub',
            'user' => $user,
            'courses' => $userCourses
        ]);
    }
    
    /**
     * Display user profile
     */
    public function profile() {
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->getById($userId);
        
        $this->render('dashboard/profile', [
            'title' => 'My Profile - IslamHub',
            'user' => $user
        ]);
    }
    
    /**
     * Process profile update
     */
    public function updateProfile() {
        $userId = $_SESSION['user_id'];
        
        $data = [
            'full_name' => $this->post('full_name'),
            'email' => $this->post('email'),
            'phone_number' => $this->post('phone_number')
        ];
        
        $result = $this->userModel->updateProfile($userId, $data);
        
        if ($result) {
            $_SESSION['full_name'] = $data['full_name'];
            $_SESSION['flash_message'] = 'Profile updated successfully';
        } else {
            $_SESSION['flash_error'] = 'Failed to update profile';
        }
        
        $this->redirect('/dashboard/profile');
    }
    
    /**
     * Process password change
     */
    public function changePassword() {
        $userId = $_SESSION['user_id'];
        $currentPassword = $this->post('current_password');
        $newPassword = $this->post('new_password');
        $confirmPassword = $this->post('confirm_password');
        
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $_SESSION['flash_error'] = 'All fields are required';
            $this->redirect('/dashboard/profile');
            return;
        }
        
        if ($newPassword !== $confirmPassword) {
            $_SESSION['flash_error'] = 'New passwords do not match';
            $this->redirect('/dashboard/profile');
            return;
        }
        
        $result = $this->userModel->changePassword($userId, $currentPassword, $newPassword);
        
        if ($result === true) {
            $_SESSION['flash_message'] = 'Password changed successfully';
        } else {
            $_SESSION['flash_error'] = $result;
        }
        
        $this->redirect('/dashboard/profile');
    }
    
    /**
     * Display user course progress
     *
     * @param int $courseId Course ID
     */
    public function courseProgress($courseId) {
        $userId = $_SESSION['user_id'];
        $course = $this->courseModel->getById($courseId);
        $progress = $this->courseModel->getUserProgress($userId, $courseId);
        
        if (!$course || !$progress) {
            $this->redirect('/dashboard');
            return;
        }
        
        $this->render('dashboard/course_progress', [
            'title' => $course['title'] . ' - Progress',
            'course' => $course,
            'progress' => $progress
        ]);
    }
} 