<?php
// Navbar links: route => label. The page's controller sets $active to highlight one.
$navLinks = [
    'dashboard'    => 'Dashboard',
    'transactions' => 'Transactions',
    'categories'   => 'Categories',
    'reports'      => 'Reports',
    'budget'       => 'Budget',
];
$active = $active ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= h($pageTitle ?? 'Expense Tracker') ?> | Expense Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?= url('dashboard') ?>">
            <img src="logo.png" alt="" class="brand-logo me-2"> Expense Tracker
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav ms-auto">
                <?php foreach ($navLinks as $route => $label): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $route === $active ? 'active' : '' ?>" href="<?= url($route) ?>"><?= $label ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <a href="<?= url('logout') ?>" class="btn btn-outline-light btn-sm ms-lg-4 mt-2 mt-lg-0">Logout</a>
        </div>
    </div>
</nav>

<div class="container py-4">
