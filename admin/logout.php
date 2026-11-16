<?php
// ============================================================
// TechnicalBabaOffice - Admin Logout
// ============================================================
require_once __DIR__ . '/../config/db.php';

require_once __DIR__ . '/../includes/functions.php';

session_name(SESSION_NAME);
session_start();

// Destroy session
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
session_destroy();

header('Location: ' . admin_url('login'));
exit;
