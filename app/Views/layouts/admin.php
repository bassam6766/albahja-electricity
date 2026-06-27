<?php
$current = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
if (!isset($newMessages)) {
    try {
        $newMessages = (int) \App\Core\Database::pdo()->query("SELECT COUNT(*) FROM contact_messages WHERE status='new'")->fetchColumn();
    } catch (\Throwable $e) { $newMessages = 0; }
}
function nav_active(string $path, string $current): string {
    if ($path === '/admin') return $current === '/admin' ? ' active' : '';
    return str_starts_with($current, $path) ? ' active' : '';
}
ob_start();
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>لوحة إدارة البهجت</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= e(asset('css/admin.css')) ?>">
</head>
<body>
<div class="admin-wrap">

  <!-- Sidebar (desktop) -->
  <aside class="sidebar">
    <div class="admin-brand">
      <img src="<?= e(asset('img/logo-small.webp')) ?>" alt="البهجت">
      <span>لوحة<br>البهجت</span>
    </div>

    <div class="nav-group">
      <div class="nav-label">عام</div>
      <a class="nav-link<?= nav_active('/admin', $current) ?>" href="/admin">
        <span class="nav-icon">🏠</span> الرئيسية
      </a>
      <a class="nav-link<?= nav_active('/admin/messages', $current) ?>" href="/admin/messages">
        <span class="nav-icon">📩</span> الرسائل
        <?php if (!empty($newMessages)): ?>
          <span class="nav-badge"><?= (int)$newMessages ?></span>
        <?php endif; ?>
      </a>
    </div>

    <div class="nav-group">
      <div class="nav-label">نصوص الصفحة الرئيسية</div>
      <?php
      $settingsGroup = $_GET['group'] ?? '';
      $sg = fn(string $g) => ($current === '/admin/settings' && $settingsGroup === $g) ? ' active' : '';
      ?>
      <a class="nav-link<?= $sg('hero') ?>" href="/admin/settings?group=hero">
        <span class="nav-icon">🏠</span> القسم الرئيسي
      </a>
      <a class="nav-link<?= $sg('why') ?>" href="/admin/settings?group=why">
        <span class="nav-icon">✅</span> لماذا البهجت
      </a>
      <a class="nav-link<?= $sg('steps') ?>" href="/admin/settings?group=steps">
        <span class="nav-icon">🔧</span> كيف نعمل
      </a>
      <a class="nav-link<?= $sg('faq') ?>" href="/admin/settings?group=faq">
        <span class="nav-icon">❓</span> الأسئلة الشائعة
      </a>
      <a class="nav-link<?= $sg('contact') ?>" href="/admin/settings?group=contact">
        <span class="nav-icon">📞</span> قسم التواصل
      </a>
      <a class="nav-link<?= $sg('general') ?>" href="/admin/settings?group=general">
        <span class="nav-icon">⚙️</span> معلومات التواصل
      </a>
    </div>

    <div class="nav-group">
      <div class="nav-label">إدارة المحتوى</div>
      <a class="nav-link<?= nav_active('/admin/services', $current) ?>" href="/admin/services">
        <span class="nav-icon">⚡</span> الخدمات
      </a>
      <a class="nav-link<?= nav_active('/admin/projects', $current) ?>" href="/admin/projects">
        <span class="nav-icon">🏗️</span> المشاريع
      </a>
      <a class="nav-link<?= nav_active('/admin/gallery', $current) ?>" href="/admin/gallery">
        <span class="nav-icon">🖼️</span> معرض الصور
      </a>
      <a class="nav-link<?= nav_active('/admin/testimonials', $current) ?>" href="/admin/testimonials">
        <span class="nav-icon">⭐</span> آراء العملاء
      </a>
    </div>

    <div class="sidebar-footer">
      <a class="nav-link" href="/" target="_blank" style="margin-bottom:8px">
        <span class="nav-icon">🌐</span> عرض الموقع
      </a>
      <form method="post" action="/admin/logout"><?= \App\Core\Csrf::field() ?>
        <button type="submit">
          <span>🚪</span> تسجيل الخروج
        </button>
      </form>
    </div>
  </aside>

  <!-- Main -->
  <main class="admin-main">

    <!-- Mobile top bar -->
    <div class="mobile-topbar">
      <div class="brand">
        <img src="<?= e(asset('img/logo-small.webp')) ?>" alt="البهجت">
        <span>لوحة البهجت</span>
      </div>
      <a href="/" target="_blank" style="color:var(--muted);font-size:13px">🌐 الموقع</a>
    </div>

    <?= $slot ?>
  </main>

</div>

<!-- Bottom nav (mobile) -->
<nav class="bottom-nav">
  <a href="/admin" class="<?= $current === '/admin' ? 'active' : '' ?>">
    <span class="bn-icon">🏠</span>الرئيسية
  </a>
  <a href="/admin/settings?group=hero" class="<?= $current === '/admin/settings' ? 'active' : '' ?>">
    <span class="bn-icon">✏️</span>النصوص
  </a>
  <a href="/admin/services" class="<?= str_starts_with($current, '/admin/services') ? 'active' : '' ?>">
    <span class="bn-icon">⚡</span>الخدمات
  </a>
  <a href="/admin/messages" class="<?= str_starts_with($current, '/admin/messages') ? 'active' : '' ?>">
    <span class="bn-icon">📩</span>الرسائل
    <?php if (!empty($newMessages)): ?><span class="bn-badge"><?= (int)$newMessages ?></span><?php endif; ?>
  </a>
  <a href="/admin/projects" class="<?= str_starts_with($current, '/admin/projects') ? 'active' : '' ?>">
    <span class="bn-icon">🏗️</span>المزيد
  </a>
</nav>

</body>
</html>
<?php echo ob_get_clean(); ?>
