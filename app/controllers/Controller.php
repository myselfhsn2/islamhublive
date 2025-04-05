<?php
/**
 * Base Controller
 * 
 * This will be the parent controller for all other controllers
 */
class Controller {
    protected $db;
    
    public function __construct() {
        require_once __DIR__ . '/../../includes/Database.php';
        $this->db = Database::getInstance();
    }
    
    /**
     * Render a view with data
     *
     * @param string $view The view file to render
     * @param array $data Data to pass to the view
     * @return void
     */
    protected function render($view, $data = []) {
        extract($data);
        
        // Include header
        require_once __DIR__ . '/../views/includes/header.php';
        
        // Include the specific view
        require_once __DIR__ . '/../views/' . $view . '.php';
        
        // Include footer
        require_once __DIR__ . '/../views/includes/footer.php';
    }
    
    /**
     * Render JSON response
     *
     * @param mixed $data Data to convert to JSON
     * @param int $statusCode HTTP status code
     * @return void
     */
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    /**
     * Redirect to a URL
     *
     * @param string $url URL to redirect to
     * @return void
     */
    protected function redirect($url) {
        header('Location: ' . $url);
        exit;
    }
    
    /**
     * Get a POST value with optional default
     * 
     * @param string $key The POST key
     * @param mixed $default Default value if key doesn't exist
     * @return mixed The POST value or default
     */
    protected function post($key, $default = null) {
        return isset($_POST[$key]) ? $this->sanitizeInput($_POST[$key]) : $default;
    }
    
    /**
     * Get a GET value with optional default
     * 
     * @param string $key The GET key
     * @param mixed $default Default value if key doesn't exist
     * @return mixed The GET value or default
     */
    protected function get($key, $default = null) {
        return isset($_GET[$key]) ? $this->sanitizeInput($_GET[$key]) : $default;
    }
    
    /**
     * Sanitize user input
     * 
     * @param mixed $input The input to sanitize
     * @return mixed Sanitized input
     */
    protected function sanitizeInput($input) {
        if (is_array($input)) {
            foreach ($input as $key => $value) {
                $input[$key] = $this->sanitizeInput($value);
            }
            return $input;
        }
        
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Check if request is AJAX
     *
     * @return bool
     */
    protected function isAjax() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
} 