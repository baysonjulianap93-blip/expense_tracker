<?php
// budgets table. category_id NULL = the overall monthly budget.
class Budget extends Model
{
    // This month's overall budget amount, or null when none is set
    public function overallForMonth(int $userId, string $month): ?float
    {
        $stmt = $this->db->prepare("
            SELECT amount FROM budgets
            WHERE user_id = ? AND month = ? AND category_id IS NULL
        ");
        $stmt->execute([$userId, $month]);
        $amount = $stmt->fetchColumn();

        return $amount === false ? null : (float)$amount;
    }

    // Insert the month's budget, or update it if one already exists
    public function saveOverall(int $userId, string $month, float $amount): void
    {
        $stmt = $this->db->prepare("
            SELECT budget_id FROM budgets
            WHERE user_id = ? AND month = ? AND category_id IS NULL
        ");
        $stmt->execute([$userId, $month]);
        $existingId = $stmt->fetchColumn();

        if ($existingId) {
            $this->db->prepare("UPDATE budgets SET amount = ? WHERE budget_id = ? AND user_id = ?")
                     ->execute([$amount, $existingId, $userId]);
        } else {
            $this->db->prepare("
                INSERT INTO budgets (user_id, category_id, amount, month)
                VALUES (?, NULL, ?, ?)
            ")->execute([$userId, $amount, $month]);
        }
    }
}
