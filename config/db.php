<?php
// ============================================================
// TechnicalBabaOffice - Database Configuration
// ============================================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // Change this for production
define('DB_PASS', '');           // Change this for production
define('DB_NAME', 'technicalbaba_db');
define('DB_CHARSET', 'utf8mb4');

// Site Base URL (no trailing slash)
define('SITE_URL', 'http://localhost/TechnicalBabaOffice');
define('ADMIN_URL', SITE_URL . '/admin');
define('ASSETS_URL', SITE_URL . '/assets');

// Session config
define('SESSION_NAME', 'techbaba_admin');
define('ADMIN_SESSION_KEY', 'admin_logged_in');

// ============================================================
// PDO Database Connection
// ============================================================
function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            die('<div style="font-family:sans-serif;padding:20px;background:#ff4444;color:#fff;border-radius:8px;">
                <h2>🔴 Database Connection Error</h2>
                <p><strong>Error:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>
                <p>Please check <code>config/db.php</code> and make sure your MySQL server is running.</p>
            </div>');
        }
    }
    return $pdo;
}
