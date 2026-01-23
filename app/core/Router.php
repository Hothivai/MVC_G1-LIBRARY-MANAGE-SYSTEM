<?php

namespace App\Core;

class Router
{
    protected array $routes = [];

    public function get(string $path, string $controller, string $action): void
    {
        $this->routes[] = [
            'method' => 'GET',
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function post(string $path, string $controller, string $action): void
    {
        $this->routes[] = [
            'method' => 'POST',
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

public function dispatch(): void
{
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = '/' . trim($uri, '/');
    $method = $_SERVER['REQUEST_METHOD'];

    foreach ($this->routes as $route) {
        if ($route['method'] === $method && $route['path'] === $uri) {

            $controllerClass = 'App\\Controllers\\' . $route['controller'];

            if (!class_exists($controllerClass)) {
                die("Controller not found: $controllerClass");
            }

            $controller = new $controllerClass();

            if (!method_exists($controller, $route['action'])) {
                die("Action not found: {$route['action']}");
            }

            call_user_func([$controller, $route['action']]);
            return;
        }
    }

    http_response_code(404);
    echo "404 - Page not found";
}

}