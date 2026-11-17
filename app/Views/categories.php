<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h2 class="fw-bold">Categories</h2>
        <p class="text-secondary mb-0">Group your transactions, like Food, Bills or Salary.</p>
    </div>
    <a href="<?php echo h(url('categories/add')); ?>" class="btn btn-primary">+ Add Category</a>
</div>

<?php if ($message): ?>
    <div class="alert alert-success"><?php echo h($message); ?></div>
<?php endif; ?>
<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo h($error); ?></div>
<?php endif; ?>

<div class="section-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="text-center">Transactions</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!$categories): ?>
                <tr><td colspan="3" class="text-center text-secondary py-4">No categories yet.</td></tr>
            <?php endif; ?>

            <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><?php echo h($cat['category_name']); ?></td>
                    <td class="text-center"><?php echo (int)$cat['tx_count']; ?></td>
                    <td class="text-end">
                        <a href="<?php echo h(url('categories/edit', ['id' => (int)$cat['category_id']])); ?>"
                           class="btn btn-sm btn-outline-primary">Edit</a>
                        <form method="post" action="<?php echo h(url('categories/delete')); ?>" class="d-inline"
                              onsubmit="return confirm('Delete this category?');">
                            <input type="hidden" name="category_id" value="<?php echo (int)$cat['category_id']; ?>">
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
