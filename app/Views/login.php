<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Expense Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css?v=2" rel="stylesheet">
</head>
<body>

<div class="container min-vh-100 d-flex align-items-center justify-content-center py-4">
    <div class="card w-100" style="max-width: 450px;">
        <div class="card-body p-4 p-md-5">

            <div class="text-center mb-4">
                <img src="logo.png" alt="Expense Tracker logo" class="auth-logo mb-3">
                <h3 class="fw-bold">Welcome Back!</h3>
                <p class="text-muted">Login to manage your expenses.</p>
            </div>

            <?php
            $displayMessage = $message ?? '';
            $displayType    = $messageType ?? $message_type ?? '';
            if (empty($displayMessage)) {
                if (!empty($error)) {
                    $displayMessage = $error;
                    $displayType    = 'error';
                } elseif (!empty($registered)) {
                    $displayMessage = 'Account created successfully! You can now log in.';
                    $displayType    = 'success';
                }
            }
            ?>
            <?php if (!empty($displayMessage)): ?>
                <div class="auth-message auth-message-<?= h($displayType) ?>">
                    <?= h($displayMessage) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= url('login') ?>" novalidate>
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email"
                           value="<?= h($email ?? '') ?>" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
            </form>

            <p class="text-center mt-4 mb-0">
                Don't have an account? <a href="<?= url('register') ?>" class="text-decoration-none">Register</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>
