<!-- Shared by Add and Edit Category -->
<div class="mb-4">
    <h2 class="fw-bold"><?= h($heading) ?></h2>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= h($error) ?></div>
<?php endif; ?>

<div class="section-card" style="max-width: 520px;">
    <form method="post">
        <div class="mb-4">
            <label class="form-label">Category name</label>
            <input type="text" name="category_name" class="form-control" maxlength="100"
                   value="<?= h($name) ?>" required autofocus>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary"><?= h($submitLabel) ?></button>
            <a href="<?= url('categories') ?>" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
