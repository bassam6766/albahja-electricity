<?php
declare(strict_types=1);

use App\Core\Env;

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function app_url(string $path = ''): string
{
    $base = rtrim(Env::get('APP_URL', ''), '/');
    if ($base === '') {
        $base = '';
    }
    return $base . '/' . ltrim($path, '/');
}

function url(string $path = ''): string
{
    return '/' . ltrim($path, '/');
}

function asset(string $path): string
{
    return url('assets/' . ltrim($path, '/'));
}

function redirect(string $path): never
{
    header('Location: ' . url($path), true, 302);
    exit;
}

function view(string $file, array $data = []): void
{
    extract($data, EXTR_SKIP);
    require APP_PATH . '/Views/' . $file . '.php';
}
