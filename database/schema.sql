SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE IF NOT EXISTS admins (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('super_admin','editor') NOT NULL DEFAULT 'super_admin',
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS categories (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  slug VARCHAR(180) NOT NULL UNIQUE,
  sort_order INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS services (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(190) NOT NULL,
  slug VARCHAR(190) NOT NULL UNIQUE,
  excerpt TEXT,
  content MEDIUMTEXT,
  image VARCHAR(255),
  sort_order INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_services_active (is_active, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS projects (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category_id BIGINT UNSIGNED NULL,
  title VARCHAR(190) NOT NULL,
  slug VARCHAR(190) NOT NULL UNIQUE,
  excerpt TEXT,
  content MEDIUMTEXT,
  image VARCHAR(255),
  sort_order INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_projects_active (is_active, sort_order),
  CONSTRAINT fk_projects_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS contact_messages (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  phone VARCHAR(40) NOT NULL,
  email VARCHAR(190),
  service VARCHAR(190) NOT NULL,
  message TEXT,
  status ENUM('new','read','closed') NOT NULL DEFAULT 'new',
  ip_address VARCHAR(64),
  user_agent VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_messages_status (status, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS settings (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `key` VARCHAR(120) NOT NULL UNIQUE,
  `value` TEXT,
  group_name VARCHAR(80) NOT NULL DEFAULT 'general',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS testimonials (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  client_name VARCHAR(160) NOT NULL,
  client_title VARCHAR(160),
  content TEXT NOT NULL,
  sort_order INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS gallery (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(190) NOT NULL,
  image VARCHAR(255) NOT NULL,
  alt_text VARCHAR(190),
  sort_order INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO categories (id, name, slug, sort_order) VALUES
(1, 'كهرباء', 'electricity', 1),
(2, 'طاقة شمسية', 'solar-energy', 2),
(3, 'صيانة', 'maintenance', 3);

INSERT IGNORE INTO services (title, slug, excerpt, sort_order) VALUES
('تمديدات وصيانة كهربائية', 'electrical-installation-maintenance', 'تأسيس وتمديد وصيانة الشبكات المنزلية والتجارية بمعايير أمان عالية.', 1),
('إصلاح الأعطال والطوارئ', 'emergency-electrical-repair', 'استجابة سريعة لانقطاع التيار والالتماس وأعطال اللوحات.', 2),
('أنظمة الطاقة الشمسية', 'solar-energy-systems', 'دراسة وتركيب ألواح شمسية لتقليل الفاتورة والاعتماد على طاقة نظيفة.', 3),
('لوحات التوزيع والحماية', 'distribution-panels-protection', 'تركيب وتأهيل لوحات الكهرباء وقواطع الحماية وأنظمة التأريض.', 4);

INSERT IGNORE INTO settings (`key`, `value`, group_name) VALUES
('phone', '98743373', 'contact'),
('whatsapp', '98743373', 'contact'),
('email', 'info@albahjatelectricity.com', 'contact'),
('address', 'الكويت', 'contact'),
('site_name', 'البهجت', 'general'),
-- Hero
('hero_title', 'طاقة بلا انقطاع<br>لمنزلك', 'hero'),
('hero_subtitle', 'من صيانة الطوارئ إلى أنظمة الطاقة الشمسية، فريق فنيين معتمدين يبقي منزلك مضيئًا وآمنًا، في أي وقت، بضمان واضح.', 'hero'),
('hero_btn_primary', 'احجز خدمة الآن', 'hero'),
('hero_btn_secondary', 'تصفّح خدماتنا', 'hero'),
('hero_badge', 'متاحون الآن · استجابة خلال 30 دقيقة', 'hero'),
-- Why
('why_title', 'تنفيذ نظيف، مواعيد واضحة، وضمان مكتوب.', 'why'),
('why_subtitle', 'نعمل كفريق واحد: فحص دقيق، تسعير واضح، تنفيذ آمن، وتسليم مرتب. الهدف أن لا تحتاج لشرح المشكلة مرتين.', 'why'),
('why_stat1_value', '30', 'why'),
('why_stat1_label', 'دقيقة متوسط الاستجابة', 'why'),
('why_stat2_value', '24/7', 'why'),
('why_stat2_label', 'طوارئ كهرباء', 'why'),
('why_stat3_value', '1', 'why'),
('why_stat3_label', 'سنة ضمان', 'why'),
-- Steps
('step1_title', 'استلام الطلب', 'steps'),
('step1_desc', 'تحدد الخدمة والموقع ووقت الزيارة المناسب.', 'steps'),
('step2_title', 'فحص وتسعير', 'steps'),
('step2_desc', 'يفحص الفني المشكلة ويعطيك السعر قبل بدء العمل.', 'steps'),
('step3_title', 'تنفيذ وضمان', 'steps'),
('step3_desc', 'تنفيذ مرتب وتسليم واضح مع توثيق الخدمة والضمان.', 'steps'),
-- FAQ
('faq1_q', 'هل تعملون خارج أوقات الدوام؟', 'faq'),
('faq1_a', 'نعم، خدمات الطوارئ متاحة على مدار الساعة حسب توفر الفريق.', 'faq'),
('faq2_q', 'هل يمكن تركيب نظام شمسي كامل؟', 'faq'),
('faq2_a', 'نعم، نعاين الموقع ونقترح حجم النظام المناسب حسب الاستهلاك والمساحة.', 'faq'),
('faq3_q', 'هل الأسعار واضحة قبل التنفيذ؟', 'faq'),
('faq3_a', 'نعم، يتم توضيح التكلفة قبل بدء العمل ولا يبدأ التنفيذ إلا بعد الموافقة.', 'faq'),
-- Contact section
('contact_title', 'خط الطوارئ', 'contact'),
('contact_subtitle', 'اترك طلبك وسنعاود الاتصال خلال دقائق، أو تواصل معنا مباشرة عبر واتساب.', 'contact');

SET FOREIGN_KEY_CHECKS = 1;
