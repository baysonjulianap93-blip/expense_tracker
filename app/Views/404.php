<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found | Expense Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
<div class="container py-5 text-center">
    <h3 class="fw-bold">Page not found</h3>
    <p class="text-secondary">The page you are looking for does not exist.</p>
    <a href="<?php echo h(url('dashboard')); ?>" class="btn btn-primary">Back to Dashboard</a>
</div>
</body>
</html>
