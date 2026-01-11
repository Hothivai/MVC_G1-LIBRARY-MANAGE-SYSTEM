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
        // Dispatch routes
    }
}
