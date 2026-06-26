<?php
declare(strict_types=1);

namespace App\Core;

final class Auth
{
    public static function boot(): void
    {
        $_SESSION['last_activity'] = time();
    }

    public static function user(): ?array
    {
        return $_SESSION['admin'] ?? null;
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function requireAdmin(): void
    {
        if (!self::check()) {
            header('Location: /admin/login', true, 302);
            exit;
        }
    }

    public static function attempt(string $password): bool
    {
        if (!hash_equals('554466', $password)) {
            return false;
        }

        session_regenerate_id(true);
        $_SESSION['admin'] = [
            'id' => 1,
            'name' => 'مدير الموقع',
            'email' => '',
            'role' => 'super_admin',
        ];
        return true;
    }

    public static function logout(): void
    {
        unset($_SESSION['admin']);
        session_regenerate_id(true);
    }
}
