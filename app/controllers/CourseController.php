<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/User.php';

/**
 * Course Controller
 * 
 * Handles course listings and details
 */
class CourseController extends Controller {
    private $courseModel;
    private $userModel;
    
    public function __construct() {
        parent::__construct();
        $this->courseModel = new Course();
        $this->userModel = new User();
    }
    
    /**
     * Display all courses
     */
    public function index() {
        $courses = $this->courseModel->getAll();
        $this->render('courses/index', [
            'title' => 'IslamHub Courses',
            'courses' => $courses,
            'metaDescription' => 'Explore all Islamic courses offered by IslamHub including Quran Reading, Memorization, and Tafseer.',
            'metaKeywords' => 'Islamic courses, Quran courses, Tajweed, Quran memorization, Tafseer'
        ]);
    }
    
    /**
     * Display single course details
     *
     * @param string $slug Course slug
     */
    public function details($slug) {
        $course = $this->courseModel->getBySlug($slug);
        
        if (!$course) {
            // Redirect to courses page if not found
            $this->redirect('/courses');
            return;
        }
        
        // Get user progress if logged in
        $userProgress = null;
        if (isset($_SESSION['user_id'])) {
            $userProgress = $this->courseModel->getUserProgress($_SESSION['user_id'], $course['id']);
        }
        
        $this->render('courses/details', [
            'title' => $course['title'] . ' - IslamHub',
            'course' => $course,
            'userProgress' => $userProgress,
            'metaDescription' => substr(strip_tags($course['description']), 0, 160),
            'metaKeywords' => $course['title'] . ', Islamic education, Quran learning, IslamHub course'
        ]);
    }
    
    /**
     * Display course enrollment page
     *
     * @param int $courseId Course ID
     */
    public function enroll($courseId) {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = "/courses/enroll/$courseId";
            $this->redirect('/auth/login');
            return;
        }
        
        $course = $this->courseModel->getById($courseId);
        
        if (!$course) {
            $this->redirect('/courses');
            return;
        }
        
        $this->render('courses/enroll', [
            'title' => 'Enroll in ' . $course['title'],
            'course' => $course
        ]);
    }
    
    /**
     * Process course enrollment
     */
    public function processEnrollment() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'You must be logged in to enroll'], 401);
            } else {
                $this->redirect('/auth/login');
            }
            return;
        }
        
        $courseId = $this->post('course_id');
        $planType = $this->post('plan_type');
        $amount = $this->post('amount');
        $paymentMethod = $this->post('payment_method');
        
        // Validate inputs
        if (empty($courseId) || empty($planType) || empty($amount) || empty($paymentMethod)) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'All fields are required'], 400);
            } else {
                $this->redirect("/courses/enroll/$courseId");
            }
            return;
        }
        
        // Convert amount to float
        $amount = floatval($amount);
        
        // Validate plan type
        if (!in_array($planType, ['flexible', 'standard', 'premium'])) {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Invalid plan type'], 400);
            } else {
                $this->redirect("/courses/enroll/$courseId");
            }
            return;
        }
        
        // Process enrollment
        $result = $this->courseModel->enrollUser($_SESSION['user_id'], $courseId, $amount, $paymentMethod, $planType);
        
        if ($result) {
            if ($this->isAjax()) {
                $this->json(['success' => true, 'message' => 'Enrollment successful']);
            } else {
                $_SESSION['flash_message'] = 'You have successfully enrolled in the course!';
                $this->redirect('/dashboard');
            }
        } else {
            if ($this->isAjax()) {
                $this->json(['success' => false, 'message' => 'Enrollment failed. Please try again.'], 500);
            } else {
                $_SESSION['flash_error'] = 'Enrollment failed. Please try again.';
                $this->redirect("/courses/enroll/$courseId");
            }
        }
    }
    
    /**
     * Update course progress via AJAX
     */
    public function updateProgress() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id']) || !$this->isAjax()) {
            $this->json(['success' => false, 'message' => 'Unauthorized'], 401);
            return;
        }
        
        $courseId = $this->post('course_id');
        $progress = $this->post('progress');
        
        if (empty($courseId) || !is_numeric($progress)) {
            $this->json(['success' => false, 'message' => 'Invalid data'], 400);
            return;
        }
        
        $result = $this->courseModel->updateProgress(
            $_SESSION['user_id'],
            $courseId,
            floatval($progress)
        );
        
        if ($result) {
            $this->json([
                'success' => true,
                'data' => $result
            ]);
        } else {
            $this->json(['success' => false, 'message' => 'Failed to update progress'], 500);
        }
    }
} 