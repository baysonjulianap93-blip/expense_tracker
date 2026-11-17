<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h2 class="fw-bold">Transactions</h2>
        <p class="text-secondary mb-0">Every income and expense you've recorded.</p>
    </div>
    <a href="<?php echo h(url('transactions/add')); ?>" class="btn btn-primary">+ Add Transaction</a>
</div>

<?php if ($message): ?>
    <div class="alert alert-success"><?php echo h($message); ?></div>
<?php endif; ?>

<div class="section-card mb-4">
    <form method="get" action="index.php" class="row g-2 align-items-end">
        <input type="hidden" name="route" value="transactions">
        <div class="col-md-3">
            <label class="form-label">Type</label>
            <select name="type" class="form-select">
                <option value="">All</option>
                <option value="Income" <?php echo $type === 'Income' ? 'selected' : ''; ?>>Income</option>
                <option value="Expense" <?php echo $type === 'Expense' ? 'selected' : ''; ?>>Expense</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Month</label>
            <input type="month" name="month" class="form-control" value="<?php echo h($month); ?>">
        </div>
        <div class="col-md-6 d-flex gap-2">
            <button class="btn btn-primary">Filter</button>
            <a href="<?php echo h(url('transactions')); ?>" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>
</div>

<div class="section-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th class="text-end">Amount</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!$transactions): ?>
                <tr><td colspan="6" class="text-center text-secondary py-4">No transactions found.</td></tr>
            <?php endif; ?>

            <?php foreach ($transactions as $t): ?>
                <tr>
                    <td><?php echo h($t['title']); ?></td>
                    <td><?php echo h($t['category_name'] ?? 'Uncategorized'); ?></td>
                    <td><?php echo h($t['transaction_date']); ?></td>
                    <td class="<?= typeClass($t['transaction_type']) ?>"><?= h($t['transaction_type']) ?></td>
                    <td class="text-end fw-semibold <?= typeClass($t['transaction_type']) ?>"><?= signedPeso($t['amount'], $t['transaction_type']) ?></td>
                    <td class="text-end">
                        <a href="<?php echo h(url('transactions/edit', ['id' => (int)$t['transaction_id']])); ?>"
                           class="btn btn-sm btn-outline-primary">Edit</a>
                        <form method="post" action="<?php echo h(url('transactions/delete')); ?>" class="d-inline"
                              onsubmit="return confirm('Delete this transaction?');">
                            <input type="hidden" name="transaction_id" value="<?php echo (int)$t['transaction_id']; ?>">
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <?php if ($transactions): ?>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end text-secondary">
                        Income <span class="income fw-semibold"><?php echo peso($income); ?></span> &middot;
                        Expenses <span class="expense fw-semibold"><?php echo peso($expense); ?></span> &middot;
                        Net <span class="fw-semibold"><?php echo peso($income - $expense); ?></span>
                    </td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
            <?php endif; ?>
        </table>
    </div>
</div>
