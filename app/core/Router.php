<?php
class Router {
    private $routes = [];
    
    public function add($method, $path, $controller, $action, $middleware = null) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action,
            'middleware' => $middleware
        ];
    }
    
    public function dispatch() {
        $url = $_GET['url'] ?? '';
        $method = $_SERVER['REQUEST_METHOD'];
        
        // Remove trailing slash
        $url = rtrim($url, '/');
        
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->match($route['path'], $url)) {
                // Apply middleware if exists
                if ($route['middleware']) {
                    $middlewareClass = $route['middleware'];
                    $middleware = new $middlewareClass();
                    if (!$middleware->handle()) {
                        return;
                    }
                }
                
                // Instantiate controller
                $controllerName = "App\\Controllers\\" . $route['controller'];
                if (!class_exists($controllerName)) {
                    http_response_code(500);
                    echo "Controller not found: " . $controllerName;
                    return;
                }
                
                $controller = new $controllerName();
                $action = $route['action'];
                
                if (!method_exists($controller, $action)) {
                    http_response_code(500);
                    echo "Action not found: " . $action;
                    return;
                }
                
                // Call action with parameters
                $params = $this->extractParams($route['path'], $url);
                call_user_func_array([$controller, $action], $params);
                return;
            }
        }
        
        // 404 Not Found
        http_response_code(404);
        $this->show404();
    }
    
    private function match($pattern, $url) {
        // Convert route pattern to regex
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $pattern);
        $pattern = '#^' . $pattern . '$#';
        return preg_match($pattern, $url);
    }
    
    private function extractParams($pattern, $url) {
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $pattern);
        $pattern = '#^' . $pattern . '$#';
        preg_match($pattern, $url, $matches);
        array_shift($matches);
        return $matches;
    }
    
    private function show404() {
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>404 - Page Not Found</title>
            <style>
                body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
                h1 { color: #e74c3c; font-size: 48px; }
                p { font-size: 18px; color: #7f8c8d; }
                a { color: #3498db; text-decoration: none; }
                a:hover { text-decoration: underline; }
            </style>
        </head>
        <body>
            <h1>404</h1>
            <h2>Trang không tìm thấy</h2>
            <p>Xin lỗi, trang bạn đang tìm kiếm không tồn tại.</p>
            <p><a href=\"/\">← Quay lại trang chủ</a></p>
        </body>
        </html>";
    }
}