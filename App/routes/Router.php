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
                // Convertir las variables de ruta en patrones de coincidencia
                $routePath = preg_replace('/\//', '\/', $routePath);
                $routePath = preg_replace('/\{([\w]+)\}/', '(?P<$1>[^\/]+)', $routePath);
                $routePath = '/^' . $routePath . '$/';

                // Hacer coincidencia con la ruta solicitada
                if (preg_match($routePath, $requestPath, $matches)) {
                    // Eliminar el primer elemento de $matches que contiene la ruta completa
                    array_shift($matches);

                    // Reemplazar las variables de ruta con sus valores en el callback
                    $callback = $this->replaceRouteVariables($callback, $matches);

                    // Ejecutar el callback
                    if (is_callable($callback)) {
                        call_user_func_array($callback, $matches);
                    } else {
                        // Manejar error: callback no válido
                        echo "Error: Invalid callback function";
                    }

                    return;
                }
            }
        }

        // Manejar error: ruta no encontrada
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