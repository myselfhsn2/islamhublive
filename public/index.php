<?php
/**
 * Main entry point for the IslamHub application
 */

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

// Load required files
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/Router.php';

// Define constants dynamically based on environment
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
$scriptName = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '';
$basePath = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
if ($basePath === '/') { $basePath = ''; }

define('BASE_PATH', $basePath);
define('BASE_URL', $protocol . '://' . $host . $basePath);
define('PUBLIC_PATH', __DIR__);

// Create router instance
$router = new Router();

// Load routes
require_once __DIR__ . '/../includes/routes.php';

// Get current URI and method
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Debug information
if (!defined('APP_DEBUG')) {
    define('APP_DEBUG', false);
}
$debug_mode = APP_DEBUG; // Set to true for verbose HTML comments

// Normalize URI and remove base path prefix
$uri = parse_url($uri, PHP_URL_PATH);
$uri = preg_replace('#^' . preg_quote(BASE_PATH, '#') . '#', '', $uri);
if (empty($uri)) {
    $uri = '/';
}

// Debug info (HTML comments, disabled by default)
if ($debug_mode) {
    echo "<!-- Original URI: " . ($_SERVER['REQUEST_URI'] ?? '') . " -->\n";
    echo "<!-- Base Path: " . BASE_PATH . " -->\n";
    echo "<!-- Processed URI: $uri -->\n";
    echo "<!-- Method: $method -->\n";
}

// Dispatch request
try {
    $router->dispatch($uri, $method);
} catch (Exception $e) {
    // Log error
    error_log($e->getMessage());
    
    if ($debug_mode) {
        // Display error details in development mode
        echo "<h1>Error Details (Debug Mode)</h1>";
        echo "<p><strong>Message:</strong> " . $e->getMessage() . "</p>";
        echo "<p><strong>File:</strong> " . $e->getFile() . " (Line: " . $e->getLine() . ")</p>";
        echo "<p><strong>Stack Trace:</strong></p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    } else {
        // Display error page in production
        http_response_code(500);
        require_once __DIR__ . '/../app/views/errors/500.php';
    }
} 