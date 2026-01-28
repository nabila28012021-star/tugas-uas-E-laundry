<?php
/**
 * E-Laundry Management System
 * Main Entry Point
 * 
 * PHP 8 + MySQL + AdminLTE
 */

declare(strict_types=1);

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Define base path
define('BASE_PATH', __DIR__);
define('BASE_URL', '/uas_kel7_database');

// Autoloader
spl_autoload_register(function ($class) {
    $paths = [
        BASE_PATH . '/core/',
        BASE_PATH . '/models/',
        BASE_PATH . '/controllers/',
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Start session
session_start();

// Initialize and run application
$app = new App();
$app->run();
