<?php
/**
 * Course Model
 * 
 * Handles operations related to courses
 */
class Course {
    private $db;
    
    public function __construct() {
        require_once __DIR__ . '/../../includes/Database.php';
        $this->db = Database::getInstance();
    }
    
    /**
     * Get all courses
     *
     * @return array Courses
     */
    public function getAll() {
        $result = $this->db->query("SELECT * FROM courses ORDER BY title");
        return $this->db->fetchAll($result);
    }
    
    /**
     * Get course by ID
     *
     * @param int $id Course ID
     * @return array|bool Course data or false
     */
    public function getById($id) {
        $result = $this->db->query("SELECT * FROM courses WHERE id = ?", [$id]);
        return $this->db->fetch($result);
    }
    
    /**
     * Get course by slug
     *
     * @param string $slug Course slug
     * @return array|bool Course data or false
     */
    public function getBySlug($slug) {
        $result = $this->db->query("SELECT * FROM courses WHERE slug = ?", [$slug]);
        return $this->db->fetch($result);
    }
    
    /**
     * Enroll a user in a course
     *
     * @param int $userId User ID
     * @param int $courseId Course ID
     * @param float $amount Payment amount
     * @param string $paymentMethod Payment method
     * @param string $planType Plan type (flexible, standard, premium)
     * @return mixed Result of enrollment procedure
     */
    public function enrollUser($userId, $courseId, $amount, $paymentMethod, $planType) {
        $result = $this->db->callProcedure('enroll_user_in_course', [$userId, $courseId, $amount, $paymentMethod, $planType]);
        
        if ($result) {
            return $this->db->fetch($result);
        }
        
        return false;
    }
    
    /**
     * Get user course progress
     *
     * @param int $userId User ID
     * @param int $courseId Course ID
     * @return array|bool Progress data or false
     */
    public function getUserProgress($userId, $courseId) {
        $query = "
            SELECT up.*, c.title as course_title
            FROM user_progress up
            JOIN courses c ON up.course_id = c.id
            WHERE up.user_id = ? AND up.course_id = ?
        ";
        
        $result = $this->db->query($query, [$userId, $courseId]);
        return $this->db->fetch($result);
    }
    
    /**
     * Update user course progress
     *
     * @param int $userId User ID
     * @param int $courseId Course ID
     * @param float $progressPercentage Progress percentage
     * @return mixed Result of update procedure
     */
    public function updateProgress($userId, $courseId, $progressPercentage) {
        $result = $this->db->callProcedure('update_user_progress', [$userId, $courseId, $progressPercentage]);
        
        if ($result) {
            return $this->db->fetch($result);
        }
        
        return false;
    }
    
    /**
     * Get all courses a user is enrolled in
     *
     * @param int $userId User ID
     * @return array User courses with progress
     */
    public function getUserCourses($userId) {
        $query = "
            SELECT c.*, up.progress_percentage, up.last_activity, up.completed,
                   p.plan_type, p.amount
            FROM courses c
            JOIN user_progress up ON c.id = up.course_id
            JOIN payments p ON c.id = p.course_id AND up.user_id = p.user_id
            WHERE up.user_id = ?
            ORDER BY up.last_activity DESC
        ";
        
        $result = $this->db->query($query, [$userId]);
        return $this->db->fetchAll($result);
    }
    
    /**
     * Get enrollment statistics using the view
     *
     * @return array Enrollment statistics
     */
    public function getEnrollmentStats() {
        $result = $this->db->query("SELECT * FROM course_enrollment_stats");
        return $this->db->fetchAll($result);
    }
} 