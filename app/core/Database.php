<?php
// One shared PDO connection for the whole request.
class Database
{
    private static ?PDO $pdo = null;

    public static function connection(): PDO
    {
        if (self::$pdo === null) {
            $c = require BASE_PATH . '/config/database.php';

            try {
                self::$pdo = new PDO(
                    "mysql:host={$c['host']};port={$c['port']};dbname={$c['name']};charset={$c['charset']}",
                    $c['user'],
                    $c['pass'],
                    [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]
                );
            } catch (PDOException $e) {
                die('Database connection failed: ' . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}
