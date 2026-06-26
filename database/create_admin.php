<?php
declare(strict_types=1);

require dirname(__DIR__) . '/app/bootstrap.php';

$email = App\Core\Env::get('ADMIN_EMAIL', 'admin@albahjatelectricity.com');
$password = App\Core\Env::get('ADMIN_PASSWORD', 'ChangeMe123!');
$hash = password_hash($password, PASSWORD_DEFAULT);

$pdo = App\Core\Database::pdo();
$stmt = $pdo->prepare('INSERT INTO admins (name, email, password_hash, role, is_active) VALUES (?, ?, ?, ?, 1) ON DUPLICATE KEY UPDATE password_hash = VALUES(password_hash), is_active = 1');
$stmt->execute(['مدير الموقع', $email, $hash, 'super_admin']);

echo "Admin user is ready: {$email}\n";
