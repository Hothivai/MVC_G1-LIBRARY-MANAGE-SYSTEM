<?php
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
        $method = $_SERVER['REQUEST_METHOD'];

        // tự động bỏ /MVC_G1-LIBRARY-MANAGE-SYSTEM/public
        $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
        if (strpos($uri, $scriptDir) === 0) {
            $uri = substr($uri, strlen($scriptDir));
        }

        if ($uri === '') {
            $uri = '/';
        }

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $uri) {

                require_once "../app/controllers/{$route['controller']}.php";

                $controller = new $route['controller']();
                $controller->{$route['action']}();
                return;
            }
        }

        http_response_code(404);
        echo "Route not found.";
    }
}
