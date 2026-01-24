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

    // 2. Xử lý loại bỏ "/public/index.php" khỏi URI nếu có
    $scriptName = $_SERVER['SCRIPT_NAME']; // Sẽ là /public/index.php
    if (strpos($uri, $scriptName) === 0) {
        $uri = substr($uri, strlen($scriptName));
    } elseif (strpos($uri, dirname($scriptName)) === 0) {
        $uri = substr($uri, strlen(dirname($scriptName)));
    }

    // 3. Chuẩn hóa URI (luôn bắt đầu bằng / và không có / ở cuối)
    $uri = '/' . trim($uri, '/');

    foreach ($this->routes as $route) {
        if ($route['method'] === $method && $route['path'] === $uri) {
            // Đường dẫn tới file controller
            $controllerPath = __DIR__ . '/../controllers/' . $route['controller'] . '.php';
            if (!file_exists($controllerPath)) {
                die('Controller file not found: ' . $controllerPath);
            }

                require_once "../app/controllers/{$route['controller']}.php";

                $controller = new $route['controller']();
                // HỖ TRỢ CONTROLLER TRONG THƯ MỤC CON (admin/...)
                $controllerPath = __DIR__ . '/../controllers/' . $route['controller'] . '.php';
            require_once $controllerPath;

            // Lấy tên Class cuối cùng (ví dụ: 'user/ProfileController' -> 'ProfileController')
            $parts = explode('/', $route['controller']);
            $className = end($parts);

            if (class_exists($className)) {
                $controller = new $className();
                $action = $route['action'];
                if (method_exists($controller, $action)) {
                    $controller->$action();
                    return;
                }
            }
        }

        http_response_code(404);
        echo "Route not found: " . htmlspecialchars($uri);
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

    http_response_code(404);
    echo "Route not found: " . htmlspecialchars($uri);
}
}
