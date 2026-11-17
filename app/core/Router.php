<?php
// Maps ?route=... to a controller method (see config/routes.php).
class Router
{
    public function __construct(private array $routes)
    {
    }

    public function dispatch(string $route): void
    {
        $route = trim($route, '/');

        if (!isset($this->routes[$route])) {
            http_response_code(404);
            require BASE_PATH . '/app/Views/404.php';
            return;
        }

        [$controllerClass, $method] = $this->routes[$route];
        (new $controllerClass())->$method();
    }
}
