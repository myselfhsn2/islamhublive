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

// Define constants
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/islamhub/public');
define('PUBLIC_PATH', __DIR__);
define('BASE_PATH', '/islamhub/public');

// Create router instance
$router = new Router();

// Load routes
require_once __DIR__ . '/../includes/routes.php';

// Get current URI and method
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Debug information
$debug_mode = true; // Set to false in production

// Remove base path from URI
$uri = str_replace(BASE_PATH, '', $uri);
if (empty($uri)) {
    $uri = '/';
}

// Debug info
if ($debug_mode) {
    echo "<!-- Original URI: " . $_SERVER['REQUEST_URI'] . " -->\n";
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