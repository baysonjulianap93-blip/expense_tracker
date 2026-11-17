<?php
// Shared form used by Add and Edit.
// Expects: $values (array), $categories (array), $error (string), $heading, $submitLabel
?>
<div class="mb-4">
    <h2 class="fw-bold"><?php echo h($heading); ?></h2>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo h($error); ?></div>
<?php endif; ?>

<?php if (!$categories): ?>
    <div class="alert alert-warning">
        You have no categories yet.
        <a href="<?php echo h(url('categories')); ?>">Add a category first</a>, then come back.
    </div>
<?php endif; ?>

<div class="section-card" style="max-width: 640px;">
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" maxlength="255"
                   value="<?php echo h($values['title']); ?>" required>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label">Amount (₱)</label>
                <input type="number" name="amount" class="form-control" step="0.01" min="0.01"
                       value="<?php echo h($values['amount']); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Type</label>
                <select name="transaction_type" class="form-select" required>
                    <option value="Expense" <?php echo $values['transaction_type'] === 'Expense' ? 'selected' : ''; ?>>Expense</option>
                    <option value="Income" <?php echo $values['transaction_type'] === 'Income' ? 'selected' : ''; ?>>Income</option>
                </select>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select" required>
                    <option value="">Choose...</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?php echo (int)$c['category_id']; ?>"
                            <?php echo (int)$values['category_id'] === (int)$c['category_id'] ? 'selected' : ''; ?>>
                            <?php echo h($c['category_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Date</label>
                <input type="date" name="transaction_date" class="form-control"
                       value="<?php echo h($values['transaction_date']); ?>" required>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-primary"><?php echo h($submitLabel); ?></button>
            <a href="<?php echo h(url('transactions')); ?>" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
