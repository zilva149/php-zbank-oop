<?php

namespace app\Controllers;

class Router
{
    private array $routes = [];

    public function get(string $path, array $action): self
    {
        $this->routes['get'][$path] = $action;
        return $this;
    }

    public function post(string $path, array $action): self
    {
        $this->routes['post'][$path] = $action;
        return $this;
    }

    public function getPath(): string
    {
        $path = $_SERVER['REQUEST_URI'];
        if (str_contains($path, '?')) {
            $path = explode('?', $path)[0];
        }
        return $path;
    }

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getRoute(string $method, string $path): ?array
    {
        return $this->routes[$method][$path] ?? null;
    }
}
