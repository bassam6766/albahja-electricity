<?php
declare(strict_types=1);

namespace App\Core;

use Throwable;

final class Router
{
    private array $routes = [];

    public function get(string $path, callable|array $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, callable|array $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $path = rtrim($path, '/') ?: '/';
        $handler = $this->routes[$method][$path] ?? null;

        if (!$handler) {
            http_response_code(404);
            view('errors/404');
            return;
        }

        try {
            if (is_array($handler)) {
                [$class, $methodName] = $handler;
                (new $class())->{$methodName}();
                return;
            }
            $handler();
        } catch (Throwable $e) {
            Logger::error('Unhandled exception', ['message' => $e->getMessage(), 'file' => $e->getFile(), 'line' => $e->getLine()]);
            http_response_code(500);
            view('errors/500');
        }
    }
}
