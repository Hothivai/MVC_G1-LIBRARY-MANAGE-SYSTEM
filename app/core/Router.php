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

    public function dispatch() {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $method = $_SERVER['REQUEST_METHOD'];

    foreach ($this->routes as $route) {
        // Sử dụng str_ends_with để khớp phần cuối của URL với path đã khai báo
        if (str_ends_with($uri, $route['path']) && $route['method'] === $method) {
            $controllerName = $route['controller'];
            $action = $route['action'];

            $controllerFile = "../app/controllers/" . $controllerName . ".php";
            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                $controller = new $controllerName();
                $controller->$action();
                return;
            }
        }
    }
    echo "404 - Trang không tồn tại.";
}
}
