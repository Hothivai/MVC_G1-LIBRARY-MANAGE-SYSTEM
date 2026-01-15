<?php

class Router
{
    protected $routes = [];

    public function get($path, $controller, $action)
    {
        $this->routes[] = ['GET', $path, $controller, $action];
    }

    public function post($path, $controller, $action)
    {
        $this->routes[] = ['POST', $path, $controller, $action];
    }

    private function getUri()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // bỏ thư mục public
        $publicDir = dirname($_SERVER['SCRIPT_NAME']);
        if ($publicDir !== '/' && strpos($uri, $publicDir) === 0) {
            $uri = substr($uri, strlen($publicDir));
        }

        // bỏ index.php nếu có
        if ($uri === '/index.php') {
            $uri = '/';
        }

        return $uri ?: '/';
    }

    public function dispatch()
    {
        $uri = $this->getUri();
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as [$m, $path, $controller, $action]) {
            if ($m === $method && $path === $uri) {

                // HỖ TRỢ CONTROLLER TRONG SUBFOLDER
                $controllerPath = dirname(__DIR__) . "/controllers/$controller.php";

                if (!file_exists($controllerPath)) {
                    http_response_code(500);
                    die("Controller not found: $controller");
                }

                require_once $controllerPath;
                $obj = new $controller();

                if (!method_exists($obj, $action)) {
                    http_response_code(500);
                    die("Action not found: $action");
                }

                $obj->$action();
                return;
            }
        }

        http_response_code(404);
        echo "Route not found.";
    }
}
