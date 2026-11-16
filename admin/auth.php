<?php
// ============================================================
// TechnicalBabaOffice - Admin Auth Guard
// Include this at the top of every admin page (after session_start)
// ============================================================
function requireAdminAuth(): void {
    if (empty($_SESSION[ADMIN_SESSION_KEY]) || empty($_SESSION['admin_id'])) {
        header('Location: ' . ADMIN_URL . '/login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
        exit;
    }
}

function getCurrentAdmin(): ?array {
    if (empty($_SESSION['admin_id'])) return null;
    $db = getDB();
    $stmt = $db->prepare("SELECT id, username, email, full_name FROM admin_users WHERE id = ?");
    $stmt->execute([$_SESSION['admin_id']]);
    return $stmt->fetch() ?: null;
}
