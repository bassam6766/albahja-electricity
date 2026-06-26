<?php
$title = $title ?? 'البهجت للكهرباء والطاقة الشمسية';
$description = $description ?? 'خدمات كهرباء وصيانة وتركيب أنظمة الطاقة الشمسية والطاقة البديلة في الكويت.';
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title) ?></title>
    <meta name="description" content="<?= e($description) ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= e(app_url()) ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= e($title) ?>">
    <meta property="og:description" content="<?= e($description) ?>">
    <meta property="og:url" content="<?= e(app_url()) ?>">
    <meta property="og:image" content="<?= e(app_url('assets/img/og-cover.svg')) ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($title) ?>">
    <meta name="twitter:description" content="<?= e($description) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(asset('css/main.css')) ?>">
    <script type="application/ld+json" nonce="<?= e(CSP_NONCE) ?>">
    {"@context":"https://schema.org","@type":"LocalBusiness","name":"البهجت","url":"<?= e(app_url()) ?>","telephone":"<?= e($settings['phone'] ?? '98743373') ?>","email":"<?= e($settings['email'] ?? 'info@albahjatelectricity.com') ?>","areaServed":"Kuwait","description":"<?= e($description) ?>","serviceType":["خدمات الكهرباء","الطاقة الشمسية","الصيانة","تركيب الأنظمة الشمسية"]}
    </script>
</head>
<body>
<?= $content ?>
<script src="<?= e(asset('js/main.js')) ?>" defer></script>
</body>
</html>
