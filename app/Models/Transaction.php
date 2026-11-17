<?php
// transactions table. Every query only touches the logged-in user's rows.
class Transaction extends Model
{
    // Income, expense and count. Pass a month (YYYY-MM) to limit it to that month.
    public function totals(int $userId, string $month = ''): array
    {
        $sql = "SELECT
                    COALESCE(SUM(CASE WHEN transaction_type = 'Income'  THEN amount END), 0) AS income,
                    COALESCE(SUM(CASE WHEN transaction_type = 'Expense' THEN amount END), 0) AS expense,
                    COUNT(*) AS cnt
                FROM transactions
                WHERE user_id = ?";
        $params = [$userId];

        if ($month !== '') {
            $sql .= " AND DATE_FORMAT(transaction_date, '%Y-%m') = ?";
            $params[] = $month;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    public function recent(int $userId, int $limit = 5): array
    {
        $stmt = $this->db->prepare("
            SELECT t.*, c.category_name
            FROM transactions t
            JOIN categories c ON t.category_id = c.category_id
            WHERE t.user_id = ?
            ORDER BY t.transaction_date DESC, t.transaction_id DESC
            LIMIT " . (int)$limit);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    // List with optional filters: $type 'Income'/'Expense', $month 'YYYY-MM'
    public function filter(int $userId, string $type = '', string $month = ''): array
    {
        $sql = "SELECT t.*, c.category_name
                FROM transactions t
                LEFT JOIN categories c ON t.category_id = c.category_id
                WHERE t.user_id = ?";
        $params = [$userId];

        if ($type !== '') {
            $sql .= " AND t.transaction_type = ?";
            $params[] = $type;
        }
        if ($month !== '') {
            $sql .= " AND DATE_FORMAT(t.transaction_date, '%Y-%m') = ?";
            $params[] = $month;
        }

        $stmt = $this->db->prepare($sql . " ORDER BY t.transaction_date DESC, t.transaction_id DESC");
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function find(int $id, int $userId): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM transactions WHERE transaction_id = ? AND user_id = ?");
        $stmt->execute([$id, $userId]);
        return $stmt->fetch() ?: null;
    }

    public function create(int $userId, array $data): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO transactions (title, amount, transaction_type, transaction_date, category_id, user_id)
            VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$data['title'], $data['amount'], $data['transaction_type'],
                        $data['transaction_date'], (int)$data['category_id'], $userId]);
    }

    public function update(int $id, int $userId, array $data): void
    {
        $stmt = $this->db->prepare("
            UPDATE transactions
            SET title = ?, amount = ?, transaction_type = ?, transaction_date = ?, category_id = ?
            WHERE transaction_id = ? AND user_id = ?");
        $stmt->execute([$data['title'], $data['amount'], $data['transaction_type'],
                        $data['transaction_date'], (int)$data['category_id'], $id, $userId]);
    }

    public function delete(int $id, int $userId): void
    {
        $stmt = $this->db->prepare("DELETE FROM transactions WHERE transaction_id = ? AND user_id = ?");
        $stmt->execute([$id, $userId]);
    }

    // ---------- Reports ----------

    public function expensesByCategory(int $userId, string $month): array
    {
        $stmt = $this->db->prepare("
            SELECT COALESCE(c.category_name, 'Uncategorized') AS category_name, SUM(t.amount) AS total
            FROM transactions t
            LEFT JOIN categories c ON t.category_id = c.category_id
            WHERE t.user_id = ? AND t.transaction_type = 'Expense'
              AND DATE_FORMAT(t.transaction_date, '%Y-%m') = ?
            GROUP BY category_name
            ORDER BY total DESC");
        $stmt->execute([$userId, $month]);
        return $stmt->fetchAll();
    }

    // Income and expenses for the latest months
    public function monthlyOverview(int $userId, int $months = 6): array
    {
        $stmt = $this->db->prepare("
            SELECT DATE_FORMAT(transaction_date, '%Y-%m') AS ym,
                   SUM(CASE WHEN transaction_type = 'Income'  THEN amount ELSE 0 END) AS income,
                   SUM(CASE WHEN transaction_type = 'Expense' THEN amount ELSE 0 END) AS expense
            FROM transactions
            WHERE user_id = ?
            GROUP BY ym
            ORDER BY ym DESC
            LIMIT " . (int)$months);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
