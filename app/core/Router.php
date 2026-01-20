<?php

class Router
{
    protected array $routes = [];

    public function get($path, $controller, $action)
    {
        $this->routes[] = [
            'method' => 'GET',
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function post($path, $controller, $action)
    {
        $this->routes[] = [
            'method' => 'POST',
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function dispatch()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        // Handle base path for subdirectory installation
        if ($uri === '/public/index.php' || $uri === '/public/') {
            $uri = '/';
        }

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $uri) {

                $controllerFile = __DIR__ . '/../controllers/' . $route['controller'] . '.php';

                if (!file_exists($controllerFile)) {
                    die('Controller not found: ' . $controllerFile);
                }

                require_once $controllerFile;

                $className = basename($route['controller']);
                $controller = new $className();

                if (!method_exists($controller, $route['action'])) {
                    die("Method {$route['action']} not found");
                }

                $controller->{$route['action']}();
                return;
            }
        }

        http_response_code(404);
        echo "Route not found: {$uri}";
    }
}