<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>دخول لوحة الإدارة</title>
  <link rel="stylesheet" href="<?= e(asset('css/admin.css')) ?>">
</head>
<body class="login-page">
  <form class="login-card" method="post" action="/admin/login">
    <?= \App\Core\Csrf::field() ?>
    <img src="<?= e(asset('img/logo-small.webp')) ?>" alt="البهجت" width="140" height="140">
    <h1>لوحة إدارة البهجت</h1>
    <p>أدخل كلمة السر فقط لإدارة محتوى الموقع.</p>
    <?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
    <label>
      <span>كلمة السر</span>
      <input type="password" name="password" inputmode="numeric" autocomplete="current-password" required autofocus>
    </label>
    <button type="submit">دخول</button>
  </form>
</body>
</html>
<?php __halt_compiler();
