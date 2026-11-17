<?php
// Front controller: every request goes through this file.
// URLs look like index.php?route=transactions/edit&id=3

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/app/core/helpers.php';

// Load core classes, controllers and models by class name
spl_autoload_register(function (string $class): void {
    foreach (['core', 'Controllers', 'Models'] as $dir) {
        $file = BASE_PATH . "/app/$dir/$class.php";
        if (is_file($file)) {
            require $file;
            return;
        }
    }
});

$routes = require BASE_PATH . '/config/routes.php';

(new Router($routes))->dispatch((string)($_GET['route'] ?? ''));
