<?php
/**
 * Router Class
 * 
 * Handles URL routing for the application
 */
class Router {
    private $routes = [
        'GET' => [],
        'POST' => []
    ];
    
    /**
     * Register a GET route
     *
     * @param string $path Route path
     * @param array $callback Controller and method to call
     * @return void
     */
    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }
    
    /**
     * Register a POST route
     *
     * @param string $path Route path
     * @param array $callback Controller and method to call
     * @return void
     */
    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }
    
    /**
     * Dispatch the request to the appropriate controller
     *
     * @param string $uri Request URI
     * @param string $method Request method
     * @return void
     */
    public function dispatch($uri, $method) {
        // Remove query string if any
        if (strpos($uri, '?') !== false) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }
        
        // Normalize URL (remove trailing slash except for root)
        $uri = rtrim($uri, '/');
        if (empty($uri)) {
            $uri = '/';
        }
        
        // Debug output
        echo "<!-- Dispatching: $method $uri -->\n";
        
        // Check if route exists directly
        if (isset($this->routes[$method][$uri])) {
            $callback = $this->routes[$method][$uri];
            echo "<!-- Route match found directly: {$callback[0]}::{$callback[1]} -->\n";
            return $this->callAction($callback[0], $callback[1]);
        }
        
        // Check for dynamic routes with parameters
        foreach ($this->routes[$method] as $route => $callback) {
            // Skip non-parameterized routes
            if (strpos($route, ':') === false) {
                continue;
            }
            
            // Convert route pattern to regex
            $routeRegex = $this->convertRouteToRegex($route);
            
            echo "<!-- Checking route: $route (regex: $routeRegex) against $uri -->\n";
            
            if (preg_match($routeRegex, $uri, $matches)) {
                // Extract parameters
                $params = [];
                $routeParts = explode('/', $route);
                $uriParts = explode('/', $uri);
                
                foreach ($routeParts as $index => $part) {
                    if (strpos($part, ':') === 0) {
                        $params[] = $uriParts[$index];
                    }
                }
                
                echo "<!-- Dynamic route match found: {$callback[0]}::{$callback[1]} with params " . json_encode($params) . " -->\n";
                
                // Call the callback with parameters
                return $this->callAction($callback[0], $callback[1], $params);
            }
        }
        
        // Debug output - list available routes
        echo "<!-- Available routes for $method method: -->\n";
        foreach ($this->routes[$method] as $route => $callback) {
            echo "<!-- - $route => {$callback[0]}::{$callback[1]} -->\n";
        }
        
        // Route not found
        echo "<!-- No route match found for: $method $uri -->\n";
        $this->notFound();
    }
    
    /**
     * Convert route pattern to regex
     * 
     * @param string $route
     * @return string
     */
    private function convertRouteToRegex($route) {
        // Replace :param with regex capture groups
        $routeRegex = preg_replace('/:[a-zA-Z0-9_]+/', '([^/]+)', $route);
        return '#^' . $routeRegex . '$#';
    }
    
    /**
     * Call the controller action with parameters
     *
     * @param string $controller Controller name
     * @param string $action Method name
     * @param array $params Parameters to pass
     * @return void
     */
    private function callAction($controller, $action, $params = []) {
        // Include controller file
        $controllerFile = __DIR__ . '/../app/controllers/' . $controller . '.php';
        if (!file_exists($controllerFile)) {
            throw new Exception("Controller $controller not found at path: $controllerFile");
        }
        
        require_once $controllerFile;
        
        // Create controller instance
        $controllerInstance = new $controller();
        
        // Check if method exists
        if (!method_exists($controllerInstance, $action)) {
            throw new Exception("Method $action not found in controller $controller");
        }
        
        // Call method with parameters
        return call_user_func_array([$controllerInstance, $action], $params);
    }
    
    /**
     * Handle 404 not found
     *
     * @return void
     */
    private function notFound() {
        http_response_code(404);
        require_once __DIR__ . '/../app/views/errors/404.php';
        exit;
    }
} 