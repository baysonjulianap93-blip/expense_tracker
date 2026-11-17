<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h2 class="fw-bold">Budget for <?= h($monthLabel) ?></h2>
        <p class="text-secondary mb-0">Set your total spending limit for this month.</p>
    </div>

    <!-- Month picker: loads the budget saved for the chosen month -->
    <form method="get" action="index.php" class="d-flex gap-2">
        <input type="hidden" name="route" value="budget">
        <input type="month" name="month" class="form-control" value="<?= h($month) ?>" required>
        <button class="btn btn-primary">View</button>
    </form>
</div>

<?php if ($message): ?>
    <div class="alert alert-success"><?= h($message) ?></div>
<?php endif; ?>

<div class="section-card" style="max-width: 520px;">
    <form method="post" action="<?= h(url('budget')) ?>">
        <input type="hidden" name="month" value="<?= h($month) ?>">
        <div class="mb-4">
            <label class="form-label">Total amount for <?= h($monthLabel) ?> (₱)</label>
            <input type="number" step="0.01" min="0" name="amount" class="form-control"
                   value="<?= h($current) ?>" placeholder="No budget set yet" required>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary">Save Budget</button>
            <a href="<?= url('dashboard') ?>" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
