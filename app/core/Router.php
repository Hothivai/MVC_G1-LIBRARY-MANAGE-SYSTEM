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

    public function dispatch()
    {
        // 1. Lấy URI hiện tại
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        // 2. Xử lý loại bỏ "/public" hoặc "/MVC_G1-LIBRARY-MANAGE-SYSTEM/public" khỏi URI nếu có
        $basePath = '/MVC_G1-LIBRARY-MANAGE-SYSTEM/public';
        if (strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }
        
        $scriptName = $_SERVER['SCRIPT_NAME'];
        if (strpos($uri, $scriptName) === 0) {
            $uri = substr($uri, strlen($scriptName));
        } elseif (strpos($uri, dirname($scriptName)) === 0) {
            $uri = substr($uri, strlen(dirname($scriptName)));
        }

        // 3. Chuẩn hóa URI (luôn bắt đầu bằng / và không có / ở cuối trừ khi là root)
        if ($uri !== '/') {
            $uri = '/' . trim($uri, '/');
        }

        // 4. Tìm route khớp
        foreach ($this->routes as $route) {

    // chuyển /user/books/show/{id} -> regex
    $pattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $route['path']);
    $pattern = '#^' . $pattern . '$#';

    if ($route['method'] === $method && preg_match($pattern, $uri, $matches)) {

        array_shift($matches); // bỏ full match

        $controllerPath = $route['controller'];
        $controllerFile = __DIR__ . '/../controllers/' . $controllerPath . '.php';

        if (!file_exists($controllerFile)) {
            http_response_code(404);
            die('Controller file not found: ' . $controllerFile);
        }

        require_once $controllerFile;

        $parts = explode('/', $controllerPath);
        $className = end($parts);

        // hỗ trợ namespace
        if (class_exists("App\\Controllers\\$className")) {
            $className = "App\\Controllers\\$className";
        }

        if (!class_exists($className)) {
            http_response_code(404);
            die("Controller class not found");
        }

        $controller = new $className();
        $action = $route['action'];

        if (!method_exists($controller, $action)) {
            http_response_code(404);
            die("Action not found");
        }

        // ⭐ truyền tham số (id)
        call_user_func_array([$controller, $action], $matches);
        return;
    }
}


        // Không tìm thấy route
        http_response_code(404);
        echo "Route not found: " . htmlspecialchars($uri);
    }
}
