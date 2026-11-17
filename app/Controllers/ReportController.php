<?php
// Monthly report: totals, expenses by category, recent months
class ReportController extends Controller
{
    public function index(): void
    {
        $userId = $this->requireLogin();

        $month = $_GET['month'] ?? date('Y-m');
        if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
            $month = date('Y-m');
        }

        $transactions = new Transaction();
        $totals = $transactions->totals($userId, $month);

        $this->render('reports', [
            'active'     => 'reports',
            'pageTitle'  => 'Reports',
            'month'      => $month,
            'totals'     => $totals,
            'net'        => $totals['income'] - $totals['expense'],
            'byCategory' => $transactions->expensesByCategory($userId, $month),
            'monthly'    => $transactions->monthlyOverview($userId),
        ]);
    }
}
