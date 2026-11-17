<?php
// categories table (categories are shared by all users)
class Category extends Model
{
    // List with the number of transactions using each category
    public function allWithTransactionCount(): array
    {
        return $this->db->query("
            SELECT c.category_id, c.category_name, COUNT(t.transaction_id) AS tx_count
            FROM categories c
            LEFT JOIN transactions t ON t.category_id = c.category_id
            GROUP BY c.category_id, c.category_name
            ORDER BY c.category_name
        ")->fetchAll();
    }

    // For dropdowns
    public function all(): array
    {
        return $this->db->query("SELECT category_id, category_name FROM categories ORDER BY category_name")
                        ->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT category_id, category_name FROM categories WHERE category_id = ?");
        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    public function create(string $name): void
    {
        $stmt = $this->db->prepare("INSERT INTO categories (category_name) VALUES (?)");
        $stmt->execute([$name]);
    }

    public function update(int $id, string $name): void
    {
        $stmt = $this->db->prepare("UPDATE categories SET category_name = ? WHERE category_id = ?");
        $stmt->execute([$name, $id]);
    }

    public function isUsedByTransactions(int $id): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM transactions WHERE category_id = ?");
        $stmt->execute([$id]);

        return $stmt->fetchColumn() > 0;
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE category_id = ?");
        $stmt->execute([$id]);
    }
}
