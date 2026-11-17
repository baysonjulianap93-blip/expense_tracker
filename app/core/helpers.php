<?php
// Small helpers shared by controllers and views.

function h($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function peso($value): string
{
    return '₱' . number_format((float)$value, 2);
}

// CSS class for a transaction type: 'income' (green) or 'expense' (red)
function typeClass(string $type): string
{
    return $type === 'Income' ? 'income' : 'expense';
}

// Amount with a sign: +₱1,500.00 for income, −₱200.00 for expenses
function signedPeso($amount, string $type): string
{
    return ($type === 'Income' ? '+' : '−') . peso($amount);
}

// Build a link to a route, e.g. url('transactions/edit', ['id' => 3])
function url(string $route = '', array $params = []): string
{
    $query = $route === '' ? $params : ['route' => $route] + $params;
    // Keep the "/" in route names readable (route=transactions/edit)
    return 'index.php' . ($query ? '?' . str_replace('%2F', '/', http_build_query($query)) : '');
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}
