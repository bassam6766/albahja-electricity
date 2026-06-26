<?php ob_start(); ?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>لوحة إدارة البهجت</title>
  <link rel="stylesheet" href="<?= e(asset('css/admin.css')) ?>">
</head>
<body>
<aside class="sidebar">
  <a class="admin-brand" href="/admin">
    <img src="<?= e(asset('img/logo-small.webp')) ?>" alt="البهجت" width="88" height="88">
    <span>لوحة البهجت</span>
  </a>
  <nav>
    <a href="/admin">الرئيسية</a>
    <a href="/admin/settings">معلومات الموقع</a>
    <a href="/admin/services">الخدمات</a>
    <a href="/admin/projects">المشاريع</a>
    <a href="/admin/gallery">الصور</a>
    <a href="/admin/categories">التصنيفات</a>
    <a href="/admin/testimonials">آراء العملاء</a>
    <a href="/admin/messages">الرسائل</a>
  </nav>
  <form method="post" action="/admin/logout"><?= \App\Core\Csrf::field() ?><button>تسجيل الخروج</button></form>
</aside>
<main class="admin-main"><?= $slot ?></main>
</body>
</html>
<?php echo ob_get_clean(); ?>
<?php __halt_compiler();
