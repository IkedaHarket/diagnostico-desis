<?php

class Router
{
    private $routes = [];

    public function get($path, $callback)
    {
        $this->addRoute('GET', $path, $callback);
    }

    public function post($path, $callback)
    {
        $this->addRoute('POST', $path, $callback);
    }

    private function addRoute($method, $path, $callback)
    {
        $this->routes[$method][$path] = $callback;
    }

    public function handleRequest($requestMethod, $requestPath)
    {
        if (isset($this->routes[$requestMethod])) {
            foreach ($this->routes[$requestMethod] as $routePath => $callback) {
                $routePath = preg_replace('/\//', '\/', $routePath);
                $routePath = preg_replace('/\{([\w]+)\}/', '(?P<$1>[^\/]+)', $routePath);
                $routePath = '/^' . $routePath . '$/';
                if (preg_match($routePath, $requestPath, $matches)) {
                    array_shift($matches);
                    $callback = $this->replaceRouteVariables($callback, $matches);
                    if (is_callable($callback)) {
                        call_user_func_array($callback, $matches);
                    } else {
                        echo "Error: Invalid callback function";
                    }

                    return;
                }
            }
        }
        echo "Error: Route not found";
    }

    private function replaceRouteVariables($callback, $matches)
    {
        if (is_array($callback) && count($callback) === 2) {
            $controller = $callback[0];
            $method = $callback[1];

            if (is_string($controller) && is_string($method)) {
                foreach ($matches as $key => $value) {
                    $method = str_replace("{{$key}}", $value, $method);
                }

                return [$controller, $method];
            }
        }

        return $callback;
    }
}