<?php
// Set the overall budget for any month (defaults to the current month)
class BudgetController extends Controller
{
    public function index(): void
    {
        $userId  = $this->requireLogin();
        $budgets = new Budget();

        // Selected month as YYYY-MM, from the picker (GET) or the save form (POST)
        $month = $_POST['month'] ?? $_GET['month'] ?? date('Y-m');
        if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
            $month = date('Y-m');
        }

        if ($this->isPost()) {
            $budgets->saveOverall($userId, $month, (float)($_POST['amount'] ?? 0));
            $this->redirectTo('budget', ['month' => $month, 'msg' => 'Budget saved.']);
        }

        $current = $budgets->overallForMonth($userId, $month);

        $this->render('budget', [
            'active'    => 'budget',
            'pageTitle' => 'Budget',
            'month'     => $month,
            'monthLabel' => date('F Y', strtotime($month . '-01')),
            'current'   => $current === null ? '' : number_format($current, 2, '.', ''),
            'message'   => $_GET['msg'] ?? '',
        ]);
    }
}
