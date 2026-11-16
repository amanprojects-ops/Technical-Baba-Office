<?php
// ============================================================
// TechnicalBabaOffice - Admin AJAX Handler
// ============================================================
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/auth.php';

session_name(SESSION_NAME);
session_start();

header('Content-Type: application/json; charset=utf-8');

if (empty($_SESSION[ADMIN_SESSION_KEY])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if (!isPost()) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$action = $_POST['action'] ?? '';

if ($action === 'toggle_status') {
    $id    = (int)($_POST['id'] ?? 0);
    $type  = $_POST['type'] ?? '';
    $value = (int)($_POST['value'] ?? 0);

    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid ID']);
        exit;
    }

    $db = getDB();
    if ($type === 'video') {
        $stmt = $db->prepare("UPDATE videos SET is_active = ? WHERE id = ?");
        $stmt->execute([$value, $id]);
        echo json_encode(['success' => true]);
        exit;
    } elseif ($type === 'service') {
        $stmt = $db->prepare("UPDATE services SET is_active = ? WHERE id = ?");
        $stmt->execute([$value, $id]);
        echo json_encode(['success' => true]);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Unknown type']);
        exit;
    }
}

echo json_encode(['success' => false, 'message' => 'Unknown action']);
exit;
