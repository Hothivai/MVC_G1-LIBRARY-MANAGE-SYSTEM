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

    

    public function dispatch()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        // Bỏ base path
        $basePath = '/MVC_G1-LIBRARY-MANAGE-SYSTEM/public';
        if (strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }

        if ($uri === '') {
            $uri = '/';
        }

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $uri) {

                require_once "../app/controllers/{$route['controller']}.php";

                $controller = new $route['controller']();
                // HỖ TRỢ CONTROLLER TRONG THƯ MỤC CON (admin/...)
                $controllerPath = __DIR__ . '/../controllers/' . $route['controller'] . '.php';

                if (!file_exists($controllerPath)) {
                    die('Controller not found: ' . $controllerPath);
                }

                require_once $controllerPath;

                // Lấy tên class (admin/DashboardController → DashboardController)
                $className = basename($route['controller']);

                $controller = new $className();

                if (!method_exists($controller, $route['action'])) {
                    die("Method {$route['action']} not found in {$className}");
                }

                $controller->{$route['action']}();
                return;
            }
        }

        http_response_code(404);
        echo "Route not found: " . htmlspecialchars($uri);
    }
}
