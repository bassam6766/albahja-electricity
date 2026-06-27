<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Database;

final class AdminController
{
    private array $resources = [
        'services' => ['title' => 'الخدمات', 'fields' => ['title', 'slug', 'excerpt', 'content', 'image', 'sort_order', 'is_active']],
        'projects' => ['title' => 'المشاريع', 'fields' => ['category_id', 'title', 'slug', 'excerpt', 'content', 'image', 'sort_order', 'is_active']],
        'categories' => ['title' => 'التصنيفات', 'fields' => ['name', 'slug', 'sort_order', 'is_active']],
        'testimonials' => ['title' => 'آراء العملاء', 'fields' => ['client_name', 'client_title', 'content', 'sort_order', 'is_active']],
        'gallery' => ['title' => 'المعرض', 'fields' => ['title', 'image', 'alt_text', 'sort_order', 'is_active']],
        'settings' => ['title' => 'الإعدادات ومعلومات التواصل', 'fields' => ['key', 'value', 'group_name']],
    ];

    public function dashboard(): void
    {
        Auth::requireAdmin();
        $pdo = Database::pdo();
        $counts = [];
        foreach (['services', 'projects', 'contact_messages', 'gallery'] as $table) {
            $counts[$table] = (int) $pdo->query("SELECT COUNT(*) FROM {$table}")->fetchColumn();
        }
        $messages = $pdo->query('SELECT * FROM contact_messages ORDER BY id DESC LIMIT 6')->fetchAll();
        $newMessages = (int) $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE status='new'")->fetchColumn();
        view('admin/dashboard', compact('counts', 'messages', 'newMessages'));
    }

    public function index(): void
    {
        Auth::requireAdmin();
        [$resource, $meta] = $this->resource();

        if ($resource === 'contact_messages') {
            $rows = Database::pdo()->query('SELECT * FROM contact_messages ORDER BY id DESC')->fetchAll();
            view('admin/messages', compact('rows'));
            return;
        }

        $order = $resource === 'settings' ? '`group_name` ASC, `key` ASC' : 'id DESC';
        $rows = Database::pdo()->query("SELECT * FROM {$resource} ORDER BY {$order}")->fetchAll();
        $labels = $this->labels();
        view('admin/resource', compact('resource', 'meta', 'rows', 'labels'));
    }

    public function store(): void
    {
        Auth::requireAdmin();
        Csrf::verify($_POST['_csrf'] ?? null);
        [$resource, $meta] = $this->resource();
        $data = $this->payload($meta['fields']);
        $columns = array_keys($data);
        $marks = implode(',', array_fill(0, count($columns), '?'));
        $sql = "INSERT INTO {$resource} (`" . implode('`,`', $columns) . "`) VALUES ({$marks})";
        Database::pdo()->prepare($sql)->execute(array_values($data));
        redirect("/admin/{$resource}");
    }

    public function update(): void
    {
        Auth::requireAdmin();
        Csrf::verify($_POST['_csrf'] ?? null);
        [$resource, $meta] = $this->resource();
        $id = (int) ($_POST['id'] ?? 0);
        $data = $this->payload($meta['fields']);
        $sets = implode(',', array_map(fn($column) => "`{$column}` = ?", array_keys($data)));
        Database::pdo()->prepare("UPDATE {$resource} SET {$sets} WHERE id = ?")->execute([...array_values($data), $id]);
        redirect("/admin/{$resource}");
    }

    public function delete(): void
    {
        Auth::requireAdmin();
        Csrf::verify($_POST['_csrf'] ?? null);
        [$resource] = $this->resource();
        $id = (int) ($_POST['id'] ?? 0);
        Database::pdo()->prepare("DELETE FROM {$resource} WHERE id = ?")->execute([$id]);
        redirect("/admin/{$resource}");
    }

    private function resource(): array
    {
        $path = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '', '/');
        $parts = explode('/', $path);
        $resource = (string) ($_GET['resource'] ?? ($parts[1] ?? ''));

        if ($resource === 'messages') {
            return ['contact_messages', ['title' => 'رسائل التواصل']];
        }

        if (!isset($this->resources[$resource])) {
            http_response_code(404);
            exit('Not found');
        }

        return [$resource, $this->resources[$resource]];
    }

    private function payload(array $fields): array
    {
        $data = [];
        foreach ($fields as $field) {
            if ($field === 'image') {
                $data[$field] = $this->upload() ?: trim((string) ($_POST[$field] ?? ''));
                continue;
            }

            if ($field === 'is_active') {
                $data[$field] = isset($_POST[$field]) ? 1 : 0;
                continue;
            }

            $data[$field] = trim((string) ($_POST[$field] ?? ''));
        }

        return $data;
    }

    private function upload(): ?string
    {
        if (empty($_FILES['upload']['tmp_name']) || !is_uploaded_file($_FILES['upload']['tmp_name'])) {
            return null;
        }

        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        $mime = mime_content_type($_FILES['upload']['tmp_name']);
        if (!isset($allowed[$mime]) || $_FILES['upload']['size'] > 3 * 1024 * 1024) {
            return null;
        }

        $dir = PUBLIC_PATH . '/uploads';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $name = bin2hex(random_bytes(12)) . '.' . $allowed[$mime];
        move_uploaded_file($_FILES['upload']['tmp_name'], $dir . '/' . $name);
        return '/uploads/' . $name;
    }

    private function labels(): array
    {
        return [
            'id' => 'الرقم',
            'title' => 'العنوان',
            'name' => 'الاسم',
            'slug' => 'الرابط المختصر',
            'excerpt' => 'وصف قصير',
            'content' => 'النص الكامل',
            'image' => 'الصورة',
            'alt_text' => 'وصف الصورة',
            'category_id' => 'رقم التصنيف',
            'client_name' => 'اسم العميل',
            'client_title' => 'صفة العميل',
            'sort_order' => 'الترتيب',
            'is_active' => 'ظاهر في الموقع',
            'key' => 'اسم الحقل',
            'value' => 'القيمة',
            'group_name' => 'المجموعة',
        ];
    }
}
