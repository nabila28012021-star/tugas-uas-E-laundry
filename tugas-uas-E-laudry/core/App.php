<?php
/**
 * Application Router Class
 */

class App
{
    protected string $controller = 'DashboardController';
    protected string $method = 'index';
    protected array $params = [];
    
    /**
     * Run the application
     */
    public function run(): void
    {
        $url = $this->parseUrl();
        
        // Handle empty URL - redirect to login or dashboard
        if (empty($url[0])) {
            if (Session::isLoggedIn()) {
                $url = ['dashboard'];
            } else {
                $url = ['auth', 'login'];
            }
        }
        
        // Determine controller
        $controllerName = ucfirst($url[0]) . 'Controller';
        $controllerFile = BASE_PATH . '/controllers/' . $controllerName . '.php';
        
        if (file_exists($controllerFile)) {
            $this->controller = $controllerName;
            unset($url[0]);
        } else {
            $this->show404();
            return;
        }
        
        // Instantiate controller
        $controllerInstance = new $this->controller();
        
        // Determine method
        if (isset($url[1])) {
            $methodName = str_replace('-', '_', $url[1]);
            if (method_exists($controllerInstance, $methodName)) {
                $this->method = $methodName;
                unset($url[1]);
            }
        }
        
        // Get remaining params
        $this->params = array_values($url);
        
        // Call controller method
        call_user_func_array([$controllerInstance, $this->method], $this->params);
    }
    
    /**
     * Parse URL into array
     */
    protected function parseUrl(): array
    {
        $url = $_GET['url'] ?? '';
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        return explode('/', $url);
    }
    
    /**
     * Show 404 page
     */
    protected function show404(): void
    {
        http_response_code(404);
        echo '<h1>404 - Page Not Found</h1>';
        echo '<p>The page you requested could not be found.</p>';
        echo '<a href="' . BASE_URL . '">Back to Home</a>';
    }
}
