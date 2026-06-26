# موقع البهجت للكهرباء والطاقة الشمسية

مشروع PHP + MySQL جاهز للاستضافة المشتركة على Namecheap/cPanel، بدون Composer أو Node runtime.

## المزايا

- واجهة عربية responsive ومحسنة للأداء.
- Backend منظم: Router، Controllers، Models، Validation، Error handling، Logging.
- لوحة إدارة على `/admin`.
- CRUD للخدمات، المشاريع، التصنيفات، المعرض، آراء العملاء، الإعدادات.
- حفظ رسائل صفحة التواصل داخل قاعدة البيانات.
- حماية CSRF، جلسات آمنة، Prepared Statements، هروب مخرجات XSS، Secure Headers.
- SEO: Meta tags، Open Graph، Twitter Cards، Schema.org، `sitemap.xml`، `robots.txt`.

## الرفع على Namecheap Shared Hosting

1. ادخل cPanel وأنشئ قاعدة بيانات MySQL ومستخدمًا من `MySQL Database Wizard`.
2. افتح phpMyAdmin واستورد الملف `database/schema.sql`.
3. انسخ `.env.example` إلى `.env` وعدل بيانات قاعدة البيانات:

```env
APP_URL=https://albahjatelectricity.com
DB_HOST=localhost
DB_NAME=cpaneluser_albahja
DB_USER=cpaneluser_albahja
DB_PASS=strong_database_password
ADMIN_EMAIL=admin@albahjatelectricity.com
ADMIN_PASSWORD=ChangeMe123!
```

4. ارفع ملفات المشروع إلى `public_html`.
5. إن كان الدومين يشير مباشرة إلى `public_html`، اترك ملف `.htaccess` الرئيسي كما هو وسيحوّل الطلبات إلى مجلد `public`.
6. شغل سكربت إنشاء المدير مرة واحدة من Terminal في cPanel:

```bash
php database/create_admin.php
```

7. احذف أو غيّر قيمة `ADMIN_PASSWORD` من `.env` بعد إنشاء المدير.
8. ادخل لوحة الإدارة من:

```text
https://albahjatelectricity.com/admin
```

## الصلاحيات المطلوبة

- PHP 8.1 أو أحدث.
- MySQL 5.7 أو MariaDB 10.3 أو أحدث.
- تفعيل إضافات PDO وfileinfo.
- صلاحية كتابة لمجلد `public/uploads` و`storage/logs`.

## ملاحظات إنتاج

- غير كلمة مرور المدير فور الدخول.
- استخدم SSL من Namecheap/cPanel.
- لا ترفع ملفات `.env` أو `storage/logs` لمستودع عام.
- عند إضافة صور من لوحة الإدارة، يفضل WebP أو JPEG مضغوط أقل من 2MB.
