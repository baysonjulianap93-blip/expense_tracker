<?php
// users table
class User extends Model
{
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("
            SELECT user_id, full_name, email, password
            FROM users
            WHERE email = ?
            LIMIT 1
        ");
        $stmt->execute([$email]);

        return $stmt->fetch() ?: null;
    }

    public function emailExists(string $email): bool
    {
        $stmt = $this->db->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        return (bool)$stmt->fetch();
    }

    // Stores the password as a secure hash
    public function create(string $fullName, string $email, string $password): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO users (full_name, email, password)
            VALUES (?, ?, ?)
        ");

        return $stmt->execute([$fullName, $email, password_hash($password, PASSWORD_DEFAULT)]);
    }
}
