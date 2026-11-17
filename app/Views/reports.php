<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h2 class="fw-bold">Reports</h2>
        <p class="text-secondary mb-0">See where your money goes each month.</p>
    </div>

    <form method="get" action="index.php" class="d-flex gap-2">
        <input type="hidden" name="route" value="reports">
        <input type="month" name="month" class="form-control" value="<?php echo h($month); ?>">
        <button class="btn btn-primary">View</button>
    </form>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="dashboard-card">
            <div class="card-label">Income (<?php echo h($month); ?>)</div>
            <div class="card-value income"><?php echo peso($totals['income']); ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="dashboard-card">
            <div class="card-label">Expenses (<?php echo h($month); ?>)</div>
            <div class="card-value expense"><?php echo peso($totals['expense']); ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="dashboard-card">
            <div class="card-label">Net for the month</div>
            <div class="card-value"><?php echo peso($net); ?></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="section-card h-100">
            <h5 class="fw-bold mb-3">Expenses by Category</h5>

            <?php if (!$byCategory): ?>
                <p class="text-secondary mb-0">No expenses recorded for this month.</p>
            <?php endif; ?>

            <?php foreach ($byCategory as $row):
                $pct = $totals['expense'] > 0 ? round($row['total'] / $totals['expense'] * 100) : 0; ?>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span><?php echo h($row['category_name']); ?></span>
                        <span class="fw-semibold expense"><?php echo peso($row['total']); ?> (<?php echo $pct; ?>%)</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-danger" style="width: <?php echo $pct; ?>%"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="section-card h-100">
            <h5 class="fw-bold mb-3">Recent Months</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th class="text-end">Income</th>
                            <th class="text-end">Expenses</th>
                            <th class="text-end">Net</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!$monthly): ?>
                        <tr><td colspan="4" class="text-center text-secondary py-4">No data yet.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($monthly as $m): ?>
                        <tr>
                            <td><a href="<?php echo h(url('reports', ['month' => $m['ym']])); ?>" class="text-decoration-none"><?php echo h($m['ym']); ?></a></td>
                            <td class="text-end income"><?php echo peso($m['income']); ?></td>
                            <td class="text-end expense"><?php echo peso($m['expense']); ?></td>
                            <td class="text-end fw-semibold"><?php echo peso($m['income'] - $m['expense']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
