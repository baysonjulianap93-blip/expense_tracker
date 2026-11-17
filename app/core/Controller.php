<?php
// Base class for all controllers: rendering, redirects and login checks.
abstract class Controller
{
    // Show app/Views/$view.php. With $withLayout the page gets the shared navbar (header.php + footer.php);
    // login and register pass false because they are shown before logging in.
    protected function render(string $view, array $data = [], bool $withLayout = true): void
    {
        extract($data);

        if ($withLayout) {
            require BASE_PATH . '/app/Views/header.php';
        }

        require BASE_PATH . "/app/Views/$view.php";

        if ($withLayout) {
            require BASE_PATH . '/app/Views/footer.php';
        }
    }

    protected function redirectTo(string $route = '', array $params = []): void
    {
        redirect(url($route, $params));
    }

    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    // Only logged-in users get past this; returns the logged-in user's id.
    protected function requireLogin(): int
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirectTo('login');
        }

        return (int)$_SESSION['user_id'];
    }
}
