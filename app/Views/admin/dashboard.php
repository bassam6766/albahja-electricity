<?php ob_start(); ?>
<div class="page-head">
  <div>
    <small>مرحبًا بك</small>
    <h1>لوحة إدارة البهجت</h1>
  </div>
  <a class="visit-link" href="/" target="_blank">🌐 عرض الموقع</a>
</div>

<div class="metric-grid">
  <a class="metric-card" href="/admin/messages">
    <strong><?= e((string)$counts['contact_messages']) ?></strong>
    <span>📩 الرسائل</span>
  </a>
  <a class="metric-card" href="/admin/services">
    <strong><?= e((string)$counts['services']) ?></strong>
    <span>⚡ الخدمات</span>
  </a>
  <a class="metric-card" href="/admin/projects">
    <strong><?= e((string)$counts['projects']) ?></strong>
    <span>🏗️ المشاريع</span>
  </a>
  <a class="metric-card" href="/admin/gallery">
    <strong><?= e((string)$counts['gallery']) ?></strong>
    <span>🖼️ الصور</span>
  </a>
</div>

<section class="panel">
  <div class="panel-head">
    <h2>📩 آخر الرسائل</h2>
    <a href="/admin/messages">عرض الكل ←</a>
  </div>
  <div class="message-list">
    <?php if (!$messages): ?>
      <p class="empty">لا توجد رسائل حتى الآن.</p>
    <?php endif; ?>
    <?php foreach ($messages as $msg): ?>
      <article>
        <strong><?= e($msg['name'] ?? '') ?></strong>
        <div class="meta"><?= e($msg['phone'] ?? '') ?> · <?= e($msg['service'] ?? '') ?></div>
        <p><?= e(mb_substr($msg['message'] ?? '', 0, 120)) ?></p>
      </article>
    <?php endforeach; ?>
  </div>
</section>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
  <a class="panel" href="/admin/settings" style="display:block;cursor:pointer;text-decoration:none">
    <div style="font-size:32px;margin-bottom:8px">✏️</div>
    <strong style="font-size:16px">تعديل نصوص الموقع</strong>
    <p style="color:var(--muted);font-size:13px;margin:4px 0 0">العنوان الرئيسي، الأسئلة، التواصل…</p>
  </a>
  <a class="panel" href="/admin/services" style="display:block;cursor:pointer;text-decoration:none">
    <div style="font-size:32px;margin-bottom:8px">⚡</div>
    <strong style="font-size:16px">إدارة الخدمات</strong>
    <p style="color:var(--muted);font-size:13px;margin:4px 0 0">إضافة وتعديل خدمات الشركة</p>
  </a>
</div>

<?php $slot = ob_get_clean(); view('layouts/admin', compact('slot', 'newMessages')); ?>
