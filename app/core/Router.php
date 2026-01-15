<?php

class Router
{
    protected $routes = [];

    public function add($method, $path, $controller, $action)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function get($path, $controller, $action)
    {
        $this->add('GET', $path, $controller, $action);
    }

    public function post($path, $controller, $action)
    {
        $this->add('POST', $path, $controller, $action);
    }

    public function dispatch()
{
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $method = $_SERVER['REQUEST_METHOD'];

    $basePath = '/MVC_G1-LIBRARY-MANAGEMENT/public';
    if (strpos($uri, $basePath) === 0) {
        $uri = substr($uri, strlen($basePath));
    }

    if ($uri === '') {
        $uri = '/';
    }

    foreach ($this->routes as $route) {
        if ($uri === $route['path'] && $method === $route['method']) {

            $controllerName = $route['controller'];
            $action = $route['action'];

            $controllerFile = __DIR__ . "/../controllers/{$controllerName}.php";

            if (!file_exists($controllerFile)) {
                die("Controller $controllerName not found");
            }

            require_once $controllerFile;
            $controller = new $controllerName();

            if (!method_exists($controller, $action)) {
                die("Method $action not found in $controllerName");
            }

            $controller->$action();
            return;
        }
    }

    http_response_code(404);
    echo "Route not found.";
}

}
