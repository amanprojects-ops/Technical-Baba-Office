-- ============================================================
-- TechnicalBabaOffice - Database Schema
-- ============================================================

CREATE DATABASE IF NOT EXISTS `technicalbaba_db`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `technicalbaba_db`;

-- ============================================================
-- Table: admin_users (Admin login)
-- ============================================================
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `username`   VARCHAR(100) NOT NULL UNIQUE,
  `password`   VARCHAR(255) NOT NULL,
  `email`      VARCHAR(150) NOT NULL,
  `full_name`  VARCHAR(150) DEFAULT NULL,
  `created_at` DATETIME     DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Default admin: password = admin@123 (bcrypt)
INSERT IGNORE INTO `admin_users` (`username`, `password`, `email`, `full_name`)
VALUES (
  'admin',
  '$2y$10$g7XUd34cn77TFgc76VmRpeIL9FvPP5SxJ6z.rKgqMipy2w2gjeOEK',
  'admin@technicalbaba.com',
  'Technical Baba Admin'
);

-- ============================================================
-- Table: site_settings (Key-value settings)
-- ============================================================
CREATE TABLE IF NOT EXISTS `site_settings` (
  `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `setting_key` VARCHAR(100) NOT NULL UNIQUE,
  `setting_value` TEXT,
  `updated_at`  DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES
  ('site_name',        'Technical Baba'),
  ('site_tagline',     'Tech Seekho, Aage Badho! 🚀'),
  ('hero_title',       'Technical Baba ke saath\nSikho, Badhao, Jito!'),
  ('hero_subtitle',    'Technology tutorials in simple Hindi & English. YouTube pe 1M+ subscribers!'),
  ('hero_cta_text',    'Videos Dekho'),
  ('hero_cta_url',     'https://youtube.com/@TechnicalBaba'),
  ('about_text',       'Technical Baba ek popular tech YouTube channel hai jo technology ko simple Hindi mein explain karta hai. Hamare videos dekhke lakho log tech seekh rahe hain.'),
  ('youtube_channel',  'https://youtube.com/@TechnicalBaba'),
  ('facebook_url',     'https://facebook.com/TechnicalBaba'),
  ('instagram_url',    'https://instagram.com/TechnicalBaba'),
  ('twitter_url',      'https://twitter.com/TechnicalBaba'),
  ('contact_email',    'contact@technicalbaba.com'),
  ('contact_phone',    '+91 98765 43210'),
  ('contact_address',  'TechnicalBabaOffice, India'),
  ('maps_embed_url',   'https://maps.google.com/maps?q=TechnicalBabaOffice&output=embed'),
  ('subscriber_count', '1,00,000+'),
  ('video_count',      '500+'),
  ('views_count',      '1 Crore+')
ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);

-- ============================================================
-- Table: services (Services / Video categories)
-- ============================================================
CREATE TABLE IF NOT EXISTS `services` (
  `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title`       VARCHAR(200) NOT NULL,
  `title_hi`    VARCHAR(200) DEFAULT NULL COMMENT 'Hindi title',
  `description` TEXT,
  `description_hi` TEXT COMMENT 'Hindi description',
  `icon`        VARCHAR(100) DEFAULT 'fa-video',
  `color`       VARCHAR(20)  DEFAULT '#ff6600',
  `is_active`   TINYINT(1)   DEFAULT 1,
  `sort_order`  INT UNSIGNED DEFAULT 0,
  `created_at`  DATETIME     DEFAULT CURRENT_TIMESTAMP,
  `updated_at`  DATETIME     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO `services` (`title`, `title_hi`, `description`, `description_hi`, `icon`, `color`, `sort_order`) VALUES
  ('YouTube Tutorials', 'यूट्यूब ट्यूटोरियल्स', 'Step-by-step technology tutorials for beginners and advanced users.', 'शुरुआती और advanced users के लिए step-by-step technology tutorials.', 'youtube', '#ff0000', 1),
  ('Tech Reviews', 'टेक रिव्यू', 'Honest reviews of latest smartphones, laptops and gadgets.', 'नए smartphones, laptops और gadgets के honest reviews.', 'star', '#ff6600', 2),
  ('How-To Guides', 'कैसे करें गाइड', 'Practical how-to guides for everyday tech problems.', 'रोजमर्रा की tech problems के लिए practical how-to guides.', 'book-open', '#1a73e8', 3),
  ('Coding Tutorials', 'कोडिंग ट्यूटोरियल्स', 'Learn programming and web development from scratch.', 'Programming और web development scratch से सीखें.', 'code', '#28a745', 4),
  ('App Reviews', 'ऐप रिव्यू', 'Reviews of trending mobile and web applications.', 'Trending mobile और web applications के reviews.', 'mobile-screen-button', '#6f42c1', 5),
  ('Tips & Tricks', 'टिप्स और ट्रिक्स', 'Hidden features and shortcuts to boost your productivity.', 'Productivity बढ़ाने के hidden features और shortcuts.', 'lightbulb', '#fd7e14', 6);

-- ============================================================
-- Table: videos (Video listings)
-- ============================================================
CREATE TABLE IF NOT EXISTS `videos` (
  `id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `service_id`   INT UNSIGNED DEFAULT NULL,
  `title`        VARCHAR(300) NOT NULL,
  `description`  TEXT,
  `youtube_id`   VARCHAR(50)  NOT NULL COMMENT 'YouTube video ID (11 chars)',
  `thumbnail`    VARCHAR(500) DEFAULT NULL,
  `duration`     VARCHAR(20)  DEFAULT NULL,
  `is_featured`  TINYINT(1)   DEFAULT 0,
  `is_active`    TINYINT(1)   DEFAULT 1,
  `sort_order`   INT UNSIGNED DEFAULT 0,
  `views`        INT UNSIGNED DEFAULT 0,
  `created_at`   DATETIME     DEFAULT CURRENT_TIMESTAMP,
  `updated_at`   DATETIME     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`service_id`) REFERENCES `services`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

INSERT INTO `videos` (`service_id`, `title`, `description`, `youtube_id`, `duration`, `is_featured`, `sort_order`) VALUES
  (1, 'ChatGPT Complete Tutorial in Hindi', 'ChatGPT kya hai aur kaise use karte hain - complete guide for beginners.', 'dQw4w9WgXcQ', '15:30', 1, 1),
  (3, 'How to Speed Up Your PC in 5 Minutes', 'PC slow ho gaya? Yeh 5 simple steps try karo!', 'dQw4w9WgXcQ', '05:12', 1, 2),
  (4, 'PHP for Beginners - Complete Course', 'PHP programming bilkul scratch se seekho - Hindi mein!', 'dQw4w9WgXcQ', '2:30:00', 1, 3),
  (2, 'iPhone 16 vs Android - Which is Better?', 'Real comparison with pros and cons in Hindi.', 'dQw4w9WgXcQ', '12:45', 0, 4),
  (5, 'Top 10 Free Apps of 2024', 'Yeh apps zaroor download karo - bilkul free hain!', 'dQw4w9WgXcQ', '08:20', 0, 5),
  (6, 'Secret WhatsApp Tricks Nobody Knows', 'WhatsApp ke yeh tricks aap nahi jaante honge!', 'dQw4w9WgXcQ', '06:50', 1, 6);

-- ============================================================
-- Table: contacts (Contact form submissions)
-- ============================================================
CREATE TABLE IF NOT EXISTS `contacts` (
  `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name`       VARCHAR(150) NOT NULL,
  `email`      VARCHAR(150) NOT NULL,
  `phone`      VARCHAR(20)  DEFAULT NULL,
  `subject`    VARCHAR(300) DEFAULT NULL,
  `message`    TEXT         NOT NULL,
  `is_read`    TINYINT(1)   DEFAULT 0,
  `is_replied` TINYINT(1)   DEFAULT 0,
  `ip_address` VARCHAR(45)  DEFAULT NULL,
  `created_at` DATETIME     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- Done!
-- ============================================================
