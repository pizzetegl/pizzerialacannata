<?php
// 1) Debug e display errori (sviluppo)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2) Autoloader PSR-4 “fai da te”
spl_autoload_register(function(string $class) {
    $prefix = 'App\\';
    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }
    $relative = substr($class, strlen($prefix));
    $file = __DIR__ . '/src/' . str_replace('\\','/',$relative) . '.php';
    if (file_exists($file)) {
        require $file;
        return;
    }
    // fallback per cartelle lowercase (controllers, models…)
    $parts = explode('/', str_replace('\\','/',$relative));
    if (count($parts) > 1) {
        $parts[0] = strtolower($parts[0]);
        $alt = __DIR__ . '/src/' . implode('/', $parts) . '.php';
        if (file_exists($alt)) {
            require $alt;
        }
    }
});

// 3) Carica la config del database
$config = require __DIR__ . '/src/config.php';

// 4) Avvia il router
$router = new App\Router();

// Determine the base subfolder from SCRIPT_NAME
$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');

// Get the incoming URI and strip any query string
$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove the base path from the request, if present
if ($basePath !== '' && strpos($requestPath, $basePath) === 0) {
    $requestPath = substr($requestPath, strlen($basePath));
}

// Ensure a leading slash and default to "/"
if ($requestPath === '' || $requestPath === false) {
    $requestPath = '/';
}

// Dispatch using the normalized path
$router->dispatch($requestPath, $_SERVER['REQUEST_METHOD']);