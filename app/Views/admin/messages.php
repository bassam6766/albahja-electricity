<?php ob_start(); ?>
<div class="page-head">
  <div>
    <small>طلبات العملاء</small>
    <h1>رسائل التواصل</h1>
  </div>
  <a class="visit-link" href="/#contact" target="_blank">صفحة التواصل</a>
</div>

<section class="content-list">
  <?php if (!$rows): ?>
    <div class="panel empty">لا توجد رسائل حتى الآن.</div>
  <?php endif; ?>
  <?php foreach ($rows as $row): ?>
    <article class="edit-card message-card">
      <div class="edit-card-head">
        <strong><?= e($row['name'] ?? '') ?></strong>
        <span><?= e($row['created_at'] ?? '') ?></span>
      </div>
      <div class="message-meta">
        <a href="tel:<?= e($row['phone'] ?? '') ?>"><?= e($row['phone'] ?? '') ?></a>
        <?php if (!empty($row['email'])): ?><a href="mailto:<?= e($row['email']) ?>"><?= e($row['email']) ?></a><?php endif; ?>
        <b><?= e($row['service'] ?? '') ?></b>
      </div>
      <p><?= e($row['message'] ?? '') ?></p>
    </article>
  <?php endforeach; ?>
</section>
<?php $slot = ob_get_clean(); view('layouts/admin', compact('slot')); ?>
