<?php
/**
 * Base Controller Class
 */

declare(strict_types=1);

class Controller
{
    protected array $data = [];
    
    /**
     * Render a view with layout
     */
    protected function view(string $view, array $data = [], string $layout = 'admin'): void
    {
        // Merge data
        $this->data = array_merge($this->data, $data);
        extract($this->data);
        
        // Start output buffering for content
        ob_start();
        $viewFile = BASE_PATH . '/views/' . $view . '.php';
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            echo "View not found: {$view}";
        }
        $content = ob_get_clean();
        
        // Load layout
        $layoutFile = BASE_PATH . '/views/layouts/' . $layout . '.php';
        if (file_exists($layoutFile)) {
            require $layoutFile;
        } else {
            echo $content;
        }
    }
    
    /**
     * Render view without layout
     */
    protected function partial(string $view, array $data = []): void
    {
        extract($data);
        $viewFile = BASE_PATH . '/views/' . $view . '.php';
        if (file_exists($viewFile)) {
            require $viewFile;
        }
    }
    
    /**
     * Redirect to URL
     */
    protected function redirect(string $url): void
    {
        header('Location: ' . BASE_URL . $url);
        exit;
    }
    
    /**
     * Return JSON response
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    /**
     * Check if request is POST
     */
    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    /**
     * Check if request is AJAX
     */
    protected function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
    
    /**
     * Get POST data
     */
    protected function post(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $default;
    }
    
    /**
     * Get GET data
     */
    protected function get(string $key, mixed $default = null): mixed
    {
        return $_GET[$key] ?? $default;
    }
    
    /**
     * Require login
     */
    protected function requireLogin(): void
    {
        if (!Session::isLoggedIn()) {
            Session::flash('error', 'Silakan login terlebih dahulu');
            $this->redirect('/auth/login');
        }
    }
    
    /**
     * Require admin role
     */
    protected function requireAdmin(): void
    {
        $this->requireLogin();
        if (!Session::isAdmin()) {
            Session::flash('error', 'Anda tidak memiliki akses ke halaman ini');
            $this->redirect('/dashboard');
        }
    }
    
    /**
     * Set page title
     */
    protected function setTitle(string $title): void
    {
        $this->data['pageTitle'] = $title;
    }
    
    /**
     * Set active menu
     */
    protected function setMenu(string $menu): void
    {
        $this->data['activeMenu'] = $menu;
    }
    
    /**
     * Sanitize input
     */
    protected function sanitize(string $input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Validate CSRF token
     */
    protected function validateCsrf(): bool
    {
        $token = $this->post('csrf_token');
        return $token && $token === Session::get('csrf_token');
    }
    
    /**
     * Generate CSRF token
     */
    protected function generateCsrf(): string
    {
        $token = bin2hex(random_bytes(32));
        Session::set('csrf_token', $token);
        return $token;
    }
}
