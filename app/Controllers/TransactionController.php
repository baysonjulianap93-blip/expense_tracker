<?php
// Income and expense records: list, add, edit, delete
class TransactionController extends Controller
{
    public function index(): void
    {
        $userId = $this->requireLogin();

        // Filters (ignored if invalid)
        $type  = in_array($_GET['type'] ?? '', ['Income', 'Expense'], true) ? $_GET['type'] : '';
        $month = preg_match('/^\d{4}-\d{2}$/', $_GET['month'] ?? '') ? $_GET['month'] : '';

        $list = (new Transaction())->filter($userId, $type, $month);

        // Totals for the footer row
        $income = $expense = 0;
        foreach ($list as $t) {
            if ($t['transaction_type'] === 'Income') {
                $income += $t['amount'];
            } else {
                $expense += $t['amount'];
            }
        }

        $this->render('transactions', [
            'active'       => 'transactions',
            'pageTitle'    => 'Transactions',
            'transactions' => $list,
            'type'         => $type,
            'month'        => $month,
            'message'      => $_GET['msg'] ?? '',
            'income'       => $income,
            'expense'      => $expense,
        ]);
    }

    public function create(): void
    {
        $this->form(null);
    }

    public function edit(): void
    {
        $userId   = $this->requireLogin();
        $existing = (new Transaction())->find((int)($_GET['id'] ?? 0), $userId);

        if (!$existing) {
            $this->redirectTo('transactions', ['msg' => 'Transaction not found.']);
        }
        $this->form($existing);
    }

    public function delete(): void
    {
        $userId = $this->requireLogin();
        $id     = (int)($_POST['transaction_id'] ?? 0);

        if ($this->isPost() && $id > 0) {
            (new Transaction())->delete($id, $userId);
            $this->redirectTo('transactions', ['msg' => 'Transaction deleted.']);
        }
        $this->redirectTo('transactions');
    }

    // Shared by Add ($existing = null) and Edit ($existing = the row)
    private function form(?array $existing): void
    {
        $userId = $this->requireLogin();
        $error  = '';
        $values = [
            'title'            => $existing['title'] ?? '',
            'amount'           => $existing['amount'] ?? '',
            'transaction_type' => $existing['transaction_type'] ?? 'Expense',
            'category_id'      => $existing['category_id'] ?? '',
            'transaction_date' => $existing['transaction_date'] ?? date('Y-m-d'),
        ];

        if ($this->isPost()) {
            foreach ($values as $key => $old) {
                $values[$key] = trim($_POST[$key] ?? '');
            }
            $error = $this->validate($values);

            if ($error === '') {
                try {
                    if ($existing) {
                        (new Transaction())->update($existing['transaction_id'], $userId, $values);
                        $this->redirectTo('transactions', ['msg' => 'Transaction updated.']);
                    }
                    (new Transaction())->create($userId, $values);
                    $this->redirectTo('transactions', ['msg' => 'Transaction added.']);
                } catch (PDOException $e) {
                    $error = 'Database error: ' . $e->getMessage();
                }
            }
        }

        $heading = $existing ? 'Edit Transaction' : 'Add Transaction';
        $this->render('transaction_form', [
            'active'      => 'transactions',
            'pageTitle'   => $heading,
            'heading'     => $heading,
            'submitLabel' => $existing ? 'Save Changes' : 'Save Transaction',
            'values'      => $values,
            'error'       => $error,
            'categories'  => (new Category())->all(),
        ]);
    }

    // Returns an error message, or '' when the form is valid
    private function validate(array $v): string
    {
        if ($v['title'] === '')                                      return 'Title is required.';
        if (!is_numeric($v['amount']) || $v['amount'] <= 0)          return 'Amount must be greater than zero.';
        if (!in_array($v['transaction_type'], ['Income', 'Expense'])) return 'Choose Income or Expense.';
        if ((int)$v['category_id'] <= 0)                             return 'Choose a category.';
        if (!DateTime::createFromFormat('Y-m-d', $v['transaction_date'])) return 'Enter a valid date.';
        return '';
    }
}
