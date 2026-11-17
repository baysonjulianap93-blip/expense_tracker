<?php $balance = $totals['income'] - $totals['expense']; ?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h2 class="fw-bold">Dashboard</h2>
        <p class="text-secondary mb-0">Welcome to your personal Expense Tracker.</p>
    </div>
    <a href="<?= url('transactions/add') ?>" class="btn btn-primary">+ Add Transaction</a>
</div>

<!-- Budget warning: at 80% and at 100% of this month's budget -->
<?php if ($budget > 0 && $spent >= $budget): ?>
    <div class="alert alert-danger d-flex justify-content-between align-items-center">
        <div><strong>Over budget!</strong> You have spent <?= peso($spent - $budget) ?> more than your <?= peso($budget) ?> budget for <?= date('F') ?>.</div>
        <a href="<?= url('budget') ?>" class="alert-link">Adjust budget</a>
    </div>
<?php elseif ($budget > 0 && $spent >= $budget * 0.8): ?>
    <div class="alert alert-warning d-flex justify-content-between align-items-center">
        <div><strong>Careful!</strong> You have used <?= $percent ?>% of your budget. Only <?= peso($budget - $spent) ?> left for <?= date('F') ?>.</div>
        <a href="<?= url('budget') ?>" class="alert-link">Adjust budget</a>
    </div>
<?php endif; ?>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="dashboard-card">
            <div class="card-label">Total Income</div>
            <div class="card-value income"><?= peso($totals['income']) ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="dashboard-card">
            <div class="card-label">Total Expenses</div>
            <div class="card-value expense"><?= peso($totals['expense']) ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="dashboard-card">
            <div class="card-label">Current Balance</div>
            <div class="card-value"><?= peso($balance) ?></div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="dashboard-card">
            <div class="card-label">Total Transactions</div>
            <div class="card-value"><?= (int)$totals['cnt'] ?></div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="dashboard-card">
            <div class="d-flex justify-content-between">
                <div class="card-label">Budget for <?= date('F Y') ?></div>
                <a href="<?= url('budget') ?>" class="text-decoration-none">Set budget</a>
            </div>

            <?php if ($budget > 0): ?>
                <div class="card-value">
                    <?= peso($spent) ?> <span class="fs-6 text-secondary">/ <?= peso($budget) ?></span>
                </div>
                <div class="progress mt-2">
                    <div class="progress-bar <?= $spent >= $budget ? 'bg-danger' : '' ?>" style="width: <?= $percent ?>%"><?= $percent ?>%</div>
                </div>
                <small class="text-secondary">
                    <?= $spent <= $budget ? peso($budget - $spent) . ' left' : 'Over budget by ' . peso($spent - $budget) ?>
                </small>
            <?php else: ?>
                <div class="text-secondary mt-3">No budget set for this month yet.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="section-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">Recent Transactions</h5>
        <a href="<?= url('transactions') ?>" class="text-decoration-none">View All</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr><th>Title</th><th>Category</th><th>Date</th><th>Type</th><th class="text-end">Amount</th></tr>
            </thead>
            <tbody>
            <?php foreach ($recent as $t): ?>
                <tr>
                    <td><?= h($t['title']) ?></td>
                    <td><?= h($t['category_name']) ?></td>
                    <td><?= h($t['transaction_date']) ?></td>
                    <td class="<?= typeClass($t['transaction_type']) ?>"><?= h($t['transaction_type']) ?></td>
                    <td class="text-end fw-semibold <?= typeClass($t['transaction_type']) ?>"><?= signedPeso($t['amount'], $t['transaction_type']) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$recent): ?>
                <tr><td colspan="5" class="text-center text-secondary py-4">No transactions recorded yet.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
