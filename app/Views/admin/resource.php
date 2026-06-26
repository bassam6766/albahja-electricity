<?php
$labels = $labels ?? [];
$label = fn(string $field): string => $labels[$field] ?? $field;
$isLong = fn(string $field): bool => in_array($field, ['content', 'excerpt', 'value'], true);
ob_start();
?>
<div class="page-head">
  <div>
    <small>تعديل المحتوى</small>
    <h1><?= e($meta['title']) ?></h1>
  </div>
  <a class="visit-link" href="/" target="_blank">عرض الموقع</a>
</div>

<section class="panel">
  <div class="panel-head"><h2>إضافة عنصر جديد</h2></div>
  <form class="resource-form" method="post" action="/admin/<?= e($resource) ?>/store" enctype="multipart/form-data">
    <?= \App\Core\Csrf::field() ?>
    <?php foreach ($meta['fields'] as $field): ?>
      <?php if ($field === 'is_active'): ?>
        <label class="check"><input type="checkbox" name="is_active" checked> <span><?= e($label($field)) ?></span></label>
      <?php elseif ($isLong($field)): ?>
        <label class="wide"><span><?= e($label($field)) ?></span><textarea name="<?= e($field) ?>"></textarea></label>
      <?php elseif ($field === 'image'): ?>
        <label><span>رابط الصورة</span><input name="image" placeholder="/uploads/photo.webp"></label>
        <label><span>رفع صورة</span><input type="file" name="upload" accept="image/png,image/jpeg,image/webp"></label>
      <?php else: ?>
        <label><span><?= e($label($field)) ?></span><input name="<?= e($field) ?>"></label>
      <?php endif; ?>
    <?php endforeach; ?>
    <button class="wide" type="submit">حفظ العنصر</button>
  </form>
</section>

<section class="content-list">
  <?php if (!$rows): ?>
    <div class="panel empty">لا توجد عناصر بعد.</div>
  <?php endif; ?>
  <?php foreach ($rows as $row): ?>
    <article class="edit-card">
      <form method="post" action="/admin/<?= e($resource) ?>/update" enctype="multipart/form-data">
        <?= \App\Core\Csrf::field() ?>
        <input type="hidden" name="id" value="<?= e((string) $row['id']) ?>">
        <div class="edit-card-head">
          <strong>#<?= e((string) $row['id']) ?> <?= e((string) ($row['title'] ?? $row['name'] ?? $row['key'] ?? 'عنصر')) ?></strong>
          <?php if (array_key_exists('is_active', $row)): ?><span><?= !empty($row['is_active']) ? 'ظاهر' : 'مخفي' ?></span><?php endif; ?>
        </div>

        <div class="resource-form compact">
          <?php foreach ($meta['fields'] as $field): ?>
            <?php if ($field === 'is_active'): ?>
              <label class="check"><input type="checkbox" name="is_active" <?= !empty($row[$field]) ? 'checked' : '' ?>> <span><?= e($label($field)) ?></span></label>
            <?php elseif ($isLong($field)): ?>
              <label class="wide"><span><?= e($label($field)) ?></span><textarea name="<?= e($field) ?>"><?= e($row[$field] ?? '') ?></textarea></label>
            <?php elseif ($field === 'image'): ?>
              <?php if (!empty($row[$field])): ?><img class="thumb" src="<?= e($row[$field]) ?>" alt=""><?php endif; ?>
              <label><span>رابط الصورة</span><input name="image" value="<?= e($row[$field] ?? '') ?>"></label>
              <label><span>رفع صورة جديدة</span><input type="file" name="upload" accept="image/png,image/jpeg,image/webp"></label>
            <?php else: ?>
              <label><span><?= e($label($field)) ?></span><input name="<?= e($field) ?>" value="<?= e((string) ($row[$field] ?? '')) ?>"></label>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>

        <div class="card-actions">
          <button type="submit">تحديث</button>
        </div>
      </form>
      <form class="delete-form" method="post" action="/admin/<?= e($resource) ?>/delete" onsubmit="return confirm('هل تريد حذف هذا العنصر؟')">
        <?= \App\Core\Csrf::field() ?>
        <input type="hidden" name="id" value="<?= e((string) $row['id']) ?>">
        <button class="danger" type="submit">حذف</button>
      </form>
    </article>
  <?php endforeach; ?>
</section>
<?php $slot = ob_get_clean(); view('layouts/admin', compact('slot')); ?>
