<?php
// Enable error reporting for development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

// Simple router
$uri = $_SERVER['REQUEST_URI'];
$uri = parse_url($uri, PHP_URL_PATH);

// Remove any subdirectory path
$base_path = dirname($_SERVER['SCRIPT_NAME']);
if ($base_path !== '/') {
    $uri = substr($uri, strlen($base_path));
}

// Remove trailing slash
$uri = rtrim($uri, '/');

// If URI is empty, it's the home page
if ($uri === '') {
    $uri = '/';
}

// Route to the appropriate controller/action
switch ($uri) {
    case '/':
        // Home page
        include 'app/controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
        
    case '/auth/login':
        // Login page
        include 'app/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;
        
    case '/auth/register':
        // Register page
        include 'app/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();
        break;
        
    case '/direct-login':
    case '/direct_login':
        // Use the direct login script
        include 'direct_login.php';
        break;
        
    case '/db-test':
    case '/db_test':
        // Database test script
        include 'db_test.php';
        break;
        
    // Add special routes for files at the root
    case '/create_test_user':
    case '/create-test-user':
        include 'create_test_user.php';
        break;
        
    default:
        // Try to match controller/action pattern
        $parts = explode('/', ltrim($uri, '/'));
        
        if (count($parts) >= 2) {
            $controller_name = ucfirst($parts[0]) . 'Controller';
            $action = $parts[1];
            
            $controller_file = 'app/controllers/' . $controller_name . '.php';
            
            if (file_exists($controller_file)) {
                include $controller_file;
                
                $controller = new $controller_name();
                
                if (method_exists($controller, $action)) {
                    // Pass any additional parameters
                    $params = array_slice($parts, 2);
                    call_user_func_array([$controller, $action], $params);
                } else {
                    http_response_code(404);
                    include 'app/views/404.php';
                }
            } else {
                http_response_code(404);
                include 'app/views/404.php';
            }
        } else {
            // Check if this might be a single file at the root
            $possible_file = ltrim($uri, '/');
            if (file_exists($possible_file . '.php')) {
                include $possible_file . '.php';
            } else {
                http_response_code(404);
                include 'app/views/404.php';
            }
        }
}
?> 