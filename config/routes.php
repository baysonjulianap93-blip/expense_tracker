<?php
// Route name (index.php?route=...) => [Controller, method]
return [
    ''                    => ['DashboardController',   'index'],
    'dashboard'           => ['DashboardController',   'index'],

    'login'               => ['AuthController',        'login'],
    'register'            => ['AuthController',        'register'],
    'logout'              => ['AuthController',        'logout'],

    'transactions'        => ['TransactionController', 'index'],
    'transactions/add'    => ['TransactionController', 'create'],
    'transactions/edit'   => ['TransactionController', 'edit'],
    'transactions/delete' => ['TransactionController', 'delete'],

    'categories'          => ['CategoryController',    'index'],
    'categories/add'      => ['CategoryController',    'create'],
    'categories/edit'     => ['CategoryController',    'edit'],
    'categories/delete'   => ['CategoryController',    'delete'],

    'budget'              => ['BudgetController',      'index'],
    'reports'             => ['ReportController',      'index'],
];
