<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function add(string $method, string $path, string $controller, string $action, $middleware = null): void
    {
        $this->routes[] = compact('method', 'path', 'controller', 'action', 'middleware');
    }

    public function dispatch(): void
    {
        $url = $_GET['url'] ?? '';
        $url = trim($url, '/');
        $method = $_SERVER['REQUEST_METHOD'];

        // Debug
        error_log("Router dispatch - URL: '$url', Method: $method");
        error_log("Total routes: " . count($this->routes));

        foreach ($this->routes as $index => $route) {
            // Debug each route check
            error_log("Checking route #$index: {$route['method']} {$route['path']}");

            if ($route['method'] !== $method) {
                error_log("  - Method mismatch");
                continue;
            }

            if (!$this->match($route['path'], $url)) {
                error_log("  - Path doesn't match");
                continue;
            }

            error_log("  ✓ MATCH FOUND!");

            // Middleware
            if ($route['middleware']) {
                $middlewareClass = "App\\Core\\" . $route['middleware'];
                if (class_exists($middlewareClass)) {
                    $middleware = new $middlewareClass();
                    if (!$middleware->handle()) {
                        error_log("  - Middleware blocked request");
                        return;
                    }
                }
            }

            $controllerClass = "App\\Controllers\\" . $route['controller'];
            
            error_log("  - Loading controller: $controllerClass");

            if (!class_exists($controllerClass)) {
                error_log("  ✗ Controller not found: $controllerClass");
                die("Controller not found: $controllerClass");
            }

            $controller = new $controllerClass();
            error_log("  - Controller instantiated");

            if (!method_exists($controller, $route['action'])) {
                error_log("  ✗ Action not found: {$route['action']}");
                die("Action not found: {$route['action']}");
            }

            error_log("  - Calling action: {$route['action']}");
            
            $params = $this->extractParams($route['path'], $url);
            call_user_func_array([$controller, $route['action']], $params);
            return;
        }

        // No route matched
        error_log("✗ No route matched for URL: '$url'");
        http_response_code(404);
        $this->show404();
    }

    private function match(string $pattern, string $url): bool
    {
        $pattern = preg_replace('/\{[^\/]+\}/', '([^/]+)', $pattern);
        $result = preg_match('#^' . $pattern . '$#', $url);
        error_log("    Pattern: '^$pattern$', URL: '$url', Result: " . ($result ? 'MATCH' : 'NO MATCH'));
        return $result;
    }

    private function extractParams(string $pattern, string $url): array
    {
        $pattern = preg_replace('/\{[^\/]+\}/', '([^/]+)', $pattern);
        preg_match('#^' . $pattern . '$#', $url, $matches);
        array_shift($matches);
        return $matches;
    }

    private function show404(): void
    {
        $file404 = __DIR__ . '/../views/errors/404.php';
        if (file_exists($file404)) {
            require $file404;
        } else {
            echo "<h1>404 - Page Not Found</h1>";
            echo "<p>The page you are looking for does not exist.</p>";
            echo "<p>URL requested: " . htmlspecialchars($_GET['url'] ?? '') . "</p>";
        }
    }
}