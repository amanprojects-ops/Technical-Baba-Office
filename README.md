# 🚀 Technical Baba Office - Dynamic Website & AdminLTE Panel

A modern, fully dynamic Personal Tech Brand website built with **PHP 8, MySQL, JavaScript & AdminLTE 3**.

---

## 🛠️ Tech Stack & Architecture

- **Backend**: PHP 8.x (Native PHP, PDO Prepared Statements, OOP/Functional Helpers)
- **Database**: MySQL 5.7+ / MariaDB 10.4+ (`utf8mb4_unicode_ci`)
- **Frontend**: HTML5, CSS3 (Modern Flexbox & CSS Grid), JavaScript (Vanilla ES6+ & jQuery)
- **CSS Framework**: Bootstrap 5 (Public frontend) & Bootstrap 4 (AdminLTE 3.2 backend)
- **Icons & Fonts**: Font Awesome 6 Pro/Free CDN, Google Fonts (Inter & Poppins)
- **Admin Panel**: AdminLTE 3.2 Theme with dark sidebar, custom cards, stats widgets & data tables
- **Security**: CSRF tokens on forms, session regeneration, XSS sanitization (`htmlspecialchars`), SQL injection immunity via PDO prepared statements, and Apache `.htaccess` hardening.

---

## 📍 Location & Contact
- **Google Maps Location**: [https://maps.app.goo.gl/YxVzxAthUP8LvEhQ6](https://maps.app.goo.gl/YxVzxAthUP8LvEhQ6)
- **Interactive Embed**: Configured in Contact section and editable via Admin Site Settings.

---

## 🌟 Key Features

### 🌐 Frontend (Public Portal)
1. **Homepage (`index.php`)**:
   - Modern Hero section with animated floating badges, particle effects, and YouTube stats.
   - Live Counter section for Subscribers, Videos, and Views.
   - Dynamic Categories & Content Showcase.
   - Trending / Featured Videos grid with modal video player (zero page reload).
   - Hindi & English bilingual copywriting.
   - Newsletter / Subscription Call-to-Action.

2. **Videos & Services Catalog (`services.php`)**:
   - Filter by categories/services with instant active state.
   - Pagination support for scalable content libraries.
   - YouTube video thumbnail and modal viewer integration.

3. **Contact Us (`contact.php`)**:
   - Responsive AJAX contact form with live character counter.
   - CSRF security protection.
   - Direct integration with Google Maps.
   - Real-time notification banners.

4. **Error Handling (`404.php`)**:
   - Custom branded 404 error page.

---

### 🛡️ Admin Panel (`/admin`)
Powered by **AdminLTE 3.2**:
1. **Authentication**: Secure bcrypt-hashed login, CSRF tokens, session verification, and auto-timeout security.
2. **Dashboard (`dashboard.php`)**: Real-time stats widgets (Total Videos, Categories, Messages, Unread count), quick action shortcuts, recent messages, and latest video uploads.
3. **Services Management (`services.php`, `add-service.php`)**: Full CRUD for content categories with icons, custom brand hex colors, bilingual titles, and sorting orders.
4. **Video Management (`videos.php`, `add-video.php`)**: Full CRUD for videos with YouTube ID parser, automatic thumbnail preview generator, duration badge, featured video pin, and visibility toggle.
5. **Messages & Inquiries (`contacts.php`)**: View incoming inquiries, filter by read/unread/replied, 1-click email reply button, and message deletion.
6. **Site Settings (`settings.php`)**: Manage site title, tagline, hero text, subscriber counters, social links (YouTube, Facebook, Instagram, Twitter/X), and contact address without touching code.

---

## 🚀 Quick Setup & Installation

### Option 1: One-Click Web Installer (Recommended)
1. Place the project folder into your web server root (e.g. `C:\xampp\htdocs\TechnicalBabaOffice`).
2. Start Apache and MySQL from XAMPP Control Panel.
3. Open your browser and navigate to:
   ```
   http://localhost/TechnicalBabaOffice/install.php
   ```
4. Click **"Install / Reset Database Now"** — it creates the database `technicalbaba_db`, creates all tables, and seeds initial data automatically!

### Option 2: Command Line (CLI)
Run the built-in migration script:
```bash
php database/migrate.php
```

---

## 🔐 Default Admin Credentials

- **Admin URL**: `http://localhost/TechnicalBabaOffice/admin/`
- **Username**: `admin`
- **Password**: `admin@123`

*(You can update password and admin details directly in `admin_users` table or via the admin settings).*

---

## 📁 Project Directory Structure

```text
TechnicalBabaOffice/
├── .htaccess                     # Apache security, caching & compression rules
├── .gitignore                    # Git ignore configurations
├── 404.php                       # Branded 404 error page
├── index.php                     # Public dynamic homepage
├── services.php                  # Services & Videos library with filters & pagination
├── contact.php                   # Contact form with Google Maps embed
├── contact-handler.php           # AJAX contact submission handler with CSRF
├── install.php                   # 1-Click web-based DB installer
├── README.md                     # Documentation
├── admin/                        # AdminLTE Control Panel
│   ├── index.php                 # Admin root router
│   ├── login.php                 # Admin secure login
│   ├── logout.php                # Session destruction & logout
│   ├── auth.php                  # Admin authentication middleware
│   ├── dashboard.php             # AdminLTE Dashboard with analytics
│   ├── services.php              # Manage services & categories
│   ├── add-service.php           # Dedicated add service page
│   ├── videos.php                # Manage videos with YouTube preview
│   ├── add-video.php             # Dedicated add video page
│   ├── contacts.php              # Manage contact inquiries & responses
│   ├── settings.php              # Manage site settings & social links
│   ├── ajax.php                  # Admin AJAX API handler
│   ├── admin.css                 # Custom AdminLTE styles & brand overrides
│   ├── admin.js                  # Admin interactivity & delete confirmations
│   └── layout/
│       ├── header.php            # AdminLTE navbar, sidebar & layout header
│       └── footer.php            # AdminLTE scripts & layout footer
├── assets/                       # Public Static Assets
│   ├── css/style.css             # Main stylesheet (Theme: Dark Blue #0d1b2a + Orange #ff6600)
│   ├── js/main.js                # Public scripts, animations, counter & modal handler
│   ├── images/                   # Site graphics & icons
│   └── uploads/                  # Media uploads directory
├── config/
│   └── db.php                    # PDO Database configuration & constants
├── database/
│   ├── schema.sql                # Complete database schema & sample seed data
│   └── migrate.php               # CLI migration runner
└── includes/
    ├── functions.php             # Core helper functions & database wrappers
    ├── header.php                # Public header, navigation & SEO meta
    └── footer.php                # Public footer, social links & script imports
```

---

## 📜 Git Commit History
1. `init: project structure + .gitignore`
2. `feat: database schema (admin_users, site_settings, services, videos, contacts)`
3. `feat: db config (PDO) + helper functions`
4. `feat: base layout - header.php + footer.php with Bootstrap 5`
5. `feat: homepage (index.php) + style.css + main.js`
6. `feat: services/videos page with pagination + category filter`
7. `feat: contact page + AJAX form handler with CSRF + Google Maps embed`
8. `feat: AdminLTE 3 admin layout (header, footer, sidebar, auth guard, admin.css, admin.js)`
9. `feat: admin dashboard with stats, quick actions + recent data tables`
10. `feat: admin CRUD for services + videos with pagination`
11. `feat: admin contacts/messages manager with read, reply, delete + filter`
12. `feat: admin site settings panel (general, hero, stats, social, contact)`
13. `feat: admin login/logout with CSRF protection + password toggle + session auth`
14. `feat: .htaccess (security, caching, gzip) + 404 custom page`
15. `feat: admin quick actions (add-video, add-service) + ajax status handler + csrf meta`
16. `feat: one-click web installer (install.php) + CLI database migrator`
17. `docs: comprehensive README documentation with setup, credentials, features & architecture`

---
Made with ❤️ for **Technical Baba Office**
