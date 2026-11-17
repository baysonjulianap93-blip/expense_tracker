<?php
// Dashboard: totals, this month's budget and recent transactions
class DashboardController extends Controller
{
    public function index(): void
    {
        $userId       = $this->requireLogin();
        $transactions = new Transaction();
        $month        = date('Y-m');

        $totals  = $transactions->totals($userId);
        $spent   = (float)$transactions->totals($userId, $month)['expense'];
        $budget  = (new Budget())->overallForMonth($userId, $month) ?? 0.0;
        $percent = $budget > 0 ? min(100, round($spent / $budget * 100)) : 0;

        $this->render('dashboard', [
            'active'    => 'dashboard',
            'pageTitle' => 'Dashboard',
            'totals'    => $totals,
            'recent'    => $transactions->recent($userId),
            'budget'    => $budget,
            'spent'     => $spent,
            'percent'   => $percent,
        ]);
    }
}
