<?php
$group   = $group ?? 'hero';
$rows    = $rows ?? [];
$saved   = $saved ?? false;

$groupMeta = [
  'hero'    => ['icon' => '🏠', 'title' => 'القسم الرئيسي (Hero)', 'desc'  => 'العنوان الكبير وأزرار الصفحة الرئيسية'],
  'why'     => ['icon' => '✅', 'title' => 'لماذا تختار البهجت',   'desc'  => 'عنوان القسم والإحصائيات'],
  'steps'   => ['icon' => '🔧', 'title' => 'كيف نعمل',             'desc'  => 'خطوات العمل الثلاث'],
  'faq'     => ['icon' => '❓', 'title' => 'الأسئلة الشائعة',      'desc'  => 'الأسئلة وإجاباتها'],
  'contact' => ['icon' => '📞', 'title' => 'قسم التواصل',          'desc'  => 'عنوان قسم الاتصال في الصفحة الرئيسية'],
  'general' => ['icon' => '⚙️', 'title' => 'معلومات التواصل',      'desc'  => 'رقم الهاتف والإيميل والعنوان'],
];

$fieldLabels = [
  // hero
  'hero_title'         => 'العنوان الرئيسي',
  'hero_subtitle'      => 'النص التوضيحي',
  'hero_btn_primary'   => 'نص الزر الأول',
  'hero_btn_secondary' => 'نص الزر الثاني',
  'hero_badge'         => 'شارة الحالة (الخضراء)',
  // why
  'why_title'          => 'عنوان القسم',
  'why_subtitle'       => 'النص التوضيحي',
  'why_stat1_value'    => 'إحصاء 1 — الرقم',
  'why_stat1_label'    => 'إحصاء 1 — الوصف',
  'why_stat2_value'    => 'إحصاء 2 — الرقم',
  'why_stat2_label'    => 'إحصاء 2 — الوصف',
  // steps
  'step1_title'        => 'الخطوة الأولى — العنوان',
  'step1_desc'         => 'الخطوة الأولى — الوصف',
  'step2_title'        => 'الخطوة الثانية — العنوان',
  'step2_desc'         => 'الخطوة الثانية — الوصف',
  'step3_title'        => 'الخطوة الثالثة — العنوان',
  'step3_desc'         => 'الخطوة الثالثة — الوصف',
  // faq
  'faq1_q'             => 'السؤال الأول',
  'faq1_a'             => 'إجابة السؤال الأول',
  'faq2_q'             => 'السؤال الثاني',
  'faq2_a'             => 'إجابة السؤال الثاني',
  'faq3_q'             => 'السؤال الثالث',
  'faq3_a'             => 'إجابة السؤال الثالث',
  // contact section text
  'contact_title'      => 'عنوان قسم التواصل',
  'contact_subtitle'   => 'النص التوضيحي',
  // general
  'phone'              => 'رقم الهاتف',
  'whatsapp'           => 'رقم واتساب',
  'email'              => 'البريد الإلكتروني',
  'address'            => 'العنوان',
  'site_name'          => 'اسم الموقع',
];

$longFields = ['hero_subtitle','why_subtitle','step1_desc','step2_desc','step3_desc','faq1_a','faq2_a','faq3_a','contact_subtitle','hero_title'];

$meta = $groupMeta[$group] ?? $groupMeta['hero'];

ob_start();
?>
<div class="page-head">
  <div>
    <small><?= $meta['icon'] ?> <?= e($meta['desc']) ?></small>
    <h1><?= e($meta['title']) ?></h1>
  </div>
  <a class="visit-link" href="/" target="_blank">🌐 عرض الموقع</a>
</div>

<?php if ($saved): ?>
  <div class="alert" style="background:rgba(34,197,94,.14);color:#86efac;border-color:rgba(34,197,94,.25)">
    ✅ تم حفظ التغييرات بنجاح.
  </div>
<?php endif; ?>

<form method="post" action="/admin/settings/save?group=<?= urlencode($group) ?>">
  <?= \App\Core\Csrf::field() ?>
  <div class="settings-section">
    <h2><?= $meta['icon'] ?> <?= e($meta['title']) ?></h2>
    <div class="settings-grid">
      <?php foreach ($rows as $row):
        $key   = $row['key'];
        $label = $fieldLabels[$key] ?? $key;
        $val   = $row['value'] ?? '';
        $isLong = in_array($key, $longFields, true);
      ?>
        <input type="hidden" name="ids[<?= e($key) ?>]" value="<?= e((string)$row['id']) ?>">
        <label class="<?= $isLong ? 'wide' : '' ?>">
          <span><?= e($label) ?></span>
          <?php if ($isLong): ?>
            <textarea name="vals[<?= e($key) ?>]" rows="3"><?= e($val) ?></textarea>
          <?php else: ?>
            <input name="vals[<?= e($key) ?>]" value="<?= e($val) ?>">
          <?php endif; ?>
        </label>
      <?php endforeach; ?>
    </div>
  </div>
  <button class="btn btn-primary" type="submit" style="min-width:160px">💾 حفظ التغييرات</button>
</form>

<?php
$slot = ob_get_clean();
view('layouts/admin', compact('slot'));
?>
