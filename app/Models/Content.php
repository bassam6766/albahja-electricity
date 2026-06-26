<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class Content
{
    public static function settings(): array
    {
        $rows = Database::pdo()->query('SELECT `key`, `value` FROM settings')->fetchAll();
        return array_column($rows, 'value', 'key');
    }

    public static function active(string $table, int $limit = 12): array
    {
        $allowed = ['services', 'projects', 'categories', 'testimonials', 'gallery'];
        if (!in_array($table, $allowed, true)) {
            return [];
        }
        $stmt = Database::pdo()->prepare("SELECT * FROM {$table} WHERE is_active = 1 ORDER BY sort_order ASC, id DESC LIMIT ?");
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
