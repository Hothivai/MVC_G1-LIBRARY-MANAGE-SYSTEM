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
    }

    http_response_code(404);
    echo "Route not found: " . htmlspecialchars($uri);
}
}
