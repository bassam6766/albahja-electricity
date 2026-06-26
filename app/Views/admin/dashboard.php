<?php ob_start(); ?>
<div class="page-head">
  <div>
    <small>مرحبًا بك</small>
    <h1>إدارة موقع البهجت</h1>
  </div>
  <a class="visit-link" href="/" target="_blank">عرض الموقع</a>
</div>

<div class="metric-grid">
  <a href="/admin/services"><strong><?= e((string) $counts['services']) ?></strong><span>الخدمات</span></a>
  <a href="/admin/projects"><strong><?= e((string) $counts['projects']) ?></strong><span>المشاريع</span></a>
  <a href="/admin/messages"><strong><?= e((string) $counts['contact_messages']) ?></strong><span>الرسائل</span></a>
  <a href="/admin/gallery"><strong><?= e((string) $counts['gallery']) ?></strong><span>الصور</span></a>
</div>

<section class="panel">
  <div class="panel-head">
    <h2>آخر الرسائل</h2>
    <a href="/admin/messages">كل الرسائل</a>
  </div>
  <div class="message-list">
    <?php if (!$messages): ?>
      <p class="empty">لا توجد رسائل حتى الآن.</p>
    <?php endif; ?>
    <?php foreach ($messages as $message): ?>
      <article>
        <strong><?= e($message['name'] ?? '') ?></strong>
        <span><?= e($message['phone'] ?? '') ?> · <?= e($message['service'] ?? '') ?></span>
        <p><?= e($message['message'] ?? '') ?></p>
      </article>
    <?php endforeach; ?>
  </div>
</section>
<?php $slot = ob_get_clean(); view('layouts/admin', compact('slot')); ?>
