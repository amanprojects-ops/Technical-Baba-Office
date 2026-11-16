<?php
// Admin root → redirect to login or dashboard
require_once __DIR__ . '/../config/db.php';
session_name(SESSION_NAME);
session_start();

if (!empty($_SESSION[ADMIN_SESSION_KEY])) {
    header('Location: dashboard.php');
} else {
    header('Location: login.php');
}
exit;
