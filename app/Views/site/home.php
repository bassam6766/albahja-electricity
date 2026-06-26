<?php
$settings = $settings ?? [];
$phone = $settings['phone'] ?? '98743373';
$whatsapp = $settings['whatsapp'] ?? $phone;
$email = $settings['email'] ?? 'info@albahjatelectricity.com';
$success = !empty($_SESSION['contact_success']);
$errors = $_SESSION['contact_errors'] ?? [];
$old = $_SESSION['contact_old'] ?? [];
unset($_SESSION['contact_success'], $_SESSION['contact_errors'], $_SESSION['contact_old']);
ob_start();
?>
<div class="site-shell">
  <header class="site-header">
    <a class="brand-logo" href="/" aria-label="البهجت">
      <img src="<?= e(asset('img/logo-small.webp')) ?>" alt="البهجت لخدمات الكهرباء والطاقة البديلة" width="160" height="160">
    </a>
    <nav class="old-nav" aria-label="روابط الموقع">
      <a href="#services">الخدمات</a>
      <a href="#why">لماذا نحن</a>
      <a href="#steps">كيف نعمل</a>
      <a href="#faq">الأسئلة</a>
      <a href="#contact">تواصل</a>
    </nav>
    <a class="nav-call" href="tel:<?= e($phone) ?>">طوارئ 24/7</a>
  </header>

  <main>
    <section class="hero-section">
      <div class="hero-bg"></div>
      <div class="hero-content reveal">
        <div class="status-pill"><span></span> متاحون الآن · استجابة خلال 30 دقيقة</div>
        <h1>طاقة بلا انقطاع<br>لمنزلك</h1>
        <p>من صيانة الطوارئ إلى أنظمة الطاقة الشمسية، فريق فنيين معتمدين يبقي منزلك مضيئًا وآمنًا، في أي وقت، بضمان واضح.</p>
        <div class="hero-actions">
          <a class="primary-btn" href="#contact">احجز خدمة الآن</a>
          <a class="ghost-btn" href="#services">تصفّح خدماتنا</a>
        </div>
        <div class="hero-ticks">
          <span>⚡ 24/7 طوارئ</span>
          <span>⚡ ضمان سنة</span>
          <span>⚡ فنيون معتمدون</span>
          <span>⚡ أسعار واضحة</span>
        </div>
      </div>
    </section>

    <section id="services" class="section services-section">
      <div class="section-title reveal">
        <small>⚡ خدماتنا</small>
        <h2>كل ما يخص الكهرباء والطاقة</h2>
      </div>
      <div class="service-grid">
        <?php
        $fallbackServices = [
          ['title' => 'تمديدات وصيانة كهربائية', 'excerpt' => 'تأسيس وتمديد كامل للمنازل الجديدة وصيانة دورية للشبكات القائمة بمعايير أمان عالية.'],
          ['title' => 'إصلاح الأعطال والطوارئ', 'excerpt' => 'استجابة سريعة لانقطاع الكهرباء، القواطع، الشورت، ولوحات التوزيع على مدار الساعة.'],
          ['title' => 'تركيب أنظمة شمسية', 'excerpt' => 'تصميم وتركيب حلول طاقة شمسية مناسبة للمنزل مع متابعة الأداء بعد التشغيل.'],
          ['title' => 'الطاقة البديلة والتوفير', 'excerpt' => 'حلول ذكية لتقليل استهلاك الكهرباء وتحسين الاعتماد على مصادر الطاقة البديلة.'],
        ];
        $cards = $services ?: $fallbackServices;
        foreach (array_slice($cards, 0, 6) as $index => $service):
        ?>
          <article class="service-card reveal">
            <b><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></b>
            <h3><?= e($service['title'] ?? '') ?></h3>
            <p><?= e($service['excerpt'] ?? $service['content'] ?? '') ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </section>

    <section id="why" class="section why-section">
      <div class="why-copy reveal">
        <small>لماذا تختار البهجت؟</small>
        <h2>تنفيذ نظيف، مواعيد واضحة، وضمان مكتوب.</h2>
        <p>نعمل كفريق واحد: فحص دقيق، تسعير واضح، تنفيذ آمن، وتسليم مرتب. الهدف أن لا تحتاج لشرح المشكلة مرتين.</p>
      </div>
      <div class="stat-grid">
        <div class="stat-card reveal"><strong>30</strong><span>دقيقة متوسط الاستجابة</span></div>
        <div class="stat-card reveal"><strong>24/7</strong><span>طوارئ كهرباء</span></div>
        <div class="stat-card reveal"><strong>1</strong><span>سنة ضمان</span></div>
      </div>
    </section>

    <section id="steps" class="section steps-section">
      <div class="section-title reveal">
        <small>طريقة العمل</small>
        <h2>من الاتصال إلى التسليم بدون تعقيد</h2>
      </div>
      <div class="steps-list">
        <div class="step-item reveal"><span>01</span><h3>استلام الطلب</h3><p>تحدد الخدمة والموقع ووقت الزيارة المناسب.</p></div>
        <div class="step-item reveal"><span>02</span><h3>فحص وتسعير</h3><p>يفحص الفني المشكلة ويعطيك السعر قبل بدء العمل.</p></div>
        <div class="step-item reveal"><span>03</span><h3>تنفيذ وضمان</h3><p>تنفيذ مرتب وتسليم واضح مع توثيق الخدمة والضمان.</p></div>
      </div>
    </section>

    <section id="faq" class="section faq-section">
      <div class="section-title reveal">
        <small>الأسئلة الشائعة</small>
        <h2>إجابات سريعة قبل التواصل</h2>
      </div>
      <div class="faq-grid">
        <details class="reveal" open><summary>هل تعملون خارج أوقات الدوام؟</summary><p>نعم، خدمات الطوارئ متاحة على مدار الساعة حسب توفر الفريق.</p></details>
        <details class="reveal"><summary>هل يمكن تركيب نظام شمسي كامل؟</summary><p>نعم، نعاين الموقع ونقترح حجم النظام المناسب حسب الاستهلاك والمساحة.</p></details>
        <details class="reveal"><summary>هل الأسعار واضحة قبل التنفيذ؟</summary><p>نعم، يتم توضيح التكلفة قبل بدء العمل ولا يبدأ التنفيذ إلا بعد الموافقة.</p></details>
      </div>
    </section>

    <section id="contact" class="section contact-section">
      <div class="contact-card reveal">
        <div class="contact-copy">
          <img src="<?= e(asset('img/logo-small.webp')) ?>" alt="البهجت" width="140" height="140">
          <small>خط الطوارئ</small>
          <a class="phone-link" href="tel:<?= e($phone) ?>"><?= e($phone) ?></a>
          <p>اترك طلبك وسنعاود الاتصال خلال دقائق، أو تواصل معنا مباشرة عبر واتساب.</p>
          <div class="contact-actions">
            <a href="https://wa.me/965<?= e($whatsapp) ?>">واتساب</a>
            <a href="tel:<?= e($phone) ?>">اتصال مباشر</a>
          </div>
          <span><?= e($email) ?></span>
        </div>
        <form class="contact-form" method="post" action="/contact">
          <?= \App\Core\Csrf::field() ?>
          <input name="name" value="<?= e($old['name'] ?? '') ?>" placeholder="الاسم" required>
          <input name="phone" value="<?= e($old['phone'] ?? '') ?>" placeholder="رقم الجوال" dir="ltr" required>
          <select name="service" required>
            <option value="">نوع الخدمة المطلوبة</option>
            <?php foreach ($cards as $service): ?>
              <option <?= (($old['service'] ?? '') === ($service['title'] ?? '')) ? 'selected' : '' ?>><?= e($service['title'] ?? '') ?></option>
            <?php endforeach; ?>
          </select>
          <textarea name="message" placeholder="وصف المشكلة أو الخدمة المطلوبة"><?= e($old['message'] ?? '') ?></textarea>
          <?php if ($success): ?><div class="notice ok">تم استلام طلبك بنجاح.</div><?php endif; ?>
          <?php if ($errors): ?><div class="notice error">يرجى مراجعة الحقول المطلوبة.</div><?php endif; ?>
          <button type="submit">إرسال الطلب</button>
        </form>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <img src="<?= e(asset('img/logo-small.webp')) ?>" alt="البهجت" width="96" height="96">
    <div>
      <strong>البهجت لخدمات الكهرباء والطاقة البديلة</strong>
      <span><?= e($phone) ?> · <?= e($email) ?></span>
    </div>
  </footer>
</div>
<?php
$content = ob_get_clean();
view('layouts/site', ['content' => $content, 'settings' => $settings, 'title' => 'البهجت للكهرباء والطاقة الشمسية']);

