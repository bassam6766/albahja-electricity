<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Database;
use App\Core\Logger;
use App\Core\Validator;
use App\Models\Content;

final class SiteController
{
    public function home(): void
    {
        view('site/home', [
            'settings' => Content::settings(),
            'services' => Content::active('services', 8),
            'projects' => Content::active('projects', 6),
            'testimonials' => Content::active('testimonials', 6),
            'gallery' => Content::active('gallery', 8),
            'success' => isset($_GET['sent']),
        ]);
    }

    public function contact(): void
    {
        Csrf::verify($_POST['_csrf'] ?? null);
        $data = [
            'name' => trim((string) ($_POST['name'] ?? '')),
            'phone' => trim((string) ($_POST['phone'] ?? '')),
            'email' => trim((string) ($_POST['email'] ?? '')),
            'service' => trim((string) ($_POST['service'] ?? '')),
            'message' => trim((string) ($_POST['message'] ?? '')),
        ];
        $errors = Validator::contact($data);
        if ($errors) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['old'] = $data;
            redirect('/#contact');
        }

        $stmt = Database::pdo()->prepare('INSERT INTO contact_messages (name, phone, email, service, message, ip_address, user_agent, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $data['name'],
            $data['phone'],
            $data['email'] ?: null,
            $data['service'],
            $data['message'] ?: null,
            $_SERVER['REMOTE_ADDR'] ?? null,
            substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255),
            'new',
        ]);
        Logger::info('Contact message saved', ['phone' => $data['phone']]);
        redirect('/?sent=1#contact');
    }

    public function apiServices(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(Content::active('services', 50), JSON_UNESCAPED_UNICODE);
    }
}
