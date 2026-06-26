<?php
declare(strict_types=1);

namespace App\Core;

final class Logger
{
    public static function error(string $message, array $context = []): void
    {
        self::write('ERROR', $message, $context);
    }

    public static function info(string $message, array $context = []): void
    {
        self::write('INFO', $message, $context);
    }

    private static function write(string $level, string $message, array $context): void
    {
        $dir = STORAGE_PATH . '/logs';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $line = sprintf("[%s] %s %s %s\n", date('c'), $level, $message, json_encode($context, JSON_UNESCAPED_UNICODE));
        file_put_contents($dir . '/app.log', $line, FILE_APPEND | LOCK_EX);
    }
}
