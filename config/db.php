<?php
// ============================================================
// TechnicalBabaOffice - Database Configuration
// ============================================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // Change this for production
define('DB_PASS', '');           // Change this for production
define('DB_NAME', 'technicalbaba_db');
define('DB_CHARSET', 'utf8mb4');

// ============================================================
// Dynamic Base URL Auto-Detection (Zero Manual Configuration)
// Works automatically on localhost, subdirectories, or live domains
// ============================================================
if (!defined('SITE_URL')) {
    $isHttps = (
        (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
        (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ||
        (!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] === 'on') ||
        (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
    );
    $protocol = $isHttps ? 'https://' : 'http://';
    $host     = $_SERVER['HTTP_HOST'] ?? 'localhost';

    // Calculate directory relative to Document Root
    $projectDir = str_replace('\\', '/', realpath(__DIR__ . '/..'));
    $docRoot    = !empty($_SERVER['DOCUMENT_ROOT']) ? str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT'])) : '';

    $basePath = '';
    if (!empty($docRoot) && strpos($projectDir, $docRoot) === 0) {
        $basePath = substr($projectDir, strlen($docRoot));
    } elseif (!empty($_SERVER['SCRIPT_NAME'])) {
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        if (strpos($scriptDir, '/admin') !== false) {
            $basePath = substr($scriptDir, 0, strpos($scriptDir, '/admin'));
        } else {
            $basePath = $scriptDir;
        }
    }
    $basePath = '/' . trim($basePath, '/');
    if ($basePath === '/') $basePath = '';

    define('BASE_PATH', $basePath);
    define('SITE_URL', rtrim($protocol . $host . $basePath, '/'));
    define('ADMIN_URL', SITE_URL . '/admin');
    define('ASSETS_URL', SITE_URL . '/assets');
}

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
