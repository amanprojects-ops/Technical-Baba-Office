<?php
// ============================================================
// TechnicalBabaOffice - Helper Functions
// ============================================================

require_once __DIR__ . '/../config/db.php';

// ============================================================
// SETTINGS HELPERS
// ============================================================

/**
 * Get a site setting value by key
 */
function getSetting(string $key, string $default = ''): string {
    $db = getDB();
    $stmt = $db->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ?");
    $stmt->execute([$key]);
    $row = $stmt->fetch();
    return $row ? (string)$row['setting_value'] : $default;
}

/**
 * Get all site settings as associative array
 */
function getAllSettings(): array {
    $db = getDB();
    $rows = $db->query("SELECT setting_key, setting_value FROM site_settings")->fetchAll();
    $settings = [];
    foreach ($rows as $row) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    return $settings;
}

/**
 * Update a site setting
 */
function updateSetting(string $key, string $value): bool {
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO site_settings (setting_key, setting_value)
                          VALUES (?, ?)
                          ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
    return $stmt->execute([$key, $value]);
}

// ============================================================
// SERVICES HELPERS
// ============================================================

function getActiveServices(): array {
    $db = getDB();
    return $db->query("SELECT * FROM services WHERE is_active = 1 ORDER BY sort_order ASC")->fetchAll();
}

function getServiceById(int $id): ?array {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM services WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

// ============================================================
// VIDEOS HELPERS
// ============================================================

function getFeaturedVideos(int $limit = 6): array {
    $db = getDB();
    $stmt = $db->prepare("SELECT v.*, s.title AS service_title, s.color AS service_color
                           FROM videos v
                           LEFT JOIN services s ON s.id = v.service_id
                           WHERE v.is_featured = 1 AND v.is_active = 1
                           ORDER BY v.sort_order ASC
                           LIMIT ?");
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
}

function getAllVideos(int $serviceId = 0, int $limit = 12, int $offset = 0): array {
    $db = getDB();
    if ($serviceId > 0) {
        $stmt = $db->prepare("SELECT v.*, s.title AS service_title, s.color AS service_color
                               FROM videos v
                               LEFT JOIN services s ON s.id = v.service_id
                               WHERE v.service_id = ? AND v.is_active = 1
                               ORDER BY v.sort_order ASC LIMIT ? OFFSET ?");
        $stmt->execute([$serviceId, $limit, $offset]);
    } else {
        $stmt = $db->prepare("SELECT v.*, s.title AS service_title, s.color AS service_color
                               FROM videos v
                               LEFT JOIN services s ON s.id = v.service_id
                               WHERE v.is_active = 1
                               ORDER BY v.sort_order ASC LIMIT ? OFFSET ?");
        $stmt->execute([$limit, $offset]);
    }
    return $stmt->fetchAll();
}

function countVideos(int $serviceId = 0): int {
    $db = getDB();
    if ($serviceId > 0) {
        $stmt = $db->prepare("SELECT COUNT(*) FROM videos WHERE service_id = ? AND is_active = 1");
        $stmt->execute([$serviceId]);
    } else {
        $stmt = $db->prepare("SELECT COUNT(*) FROM videos WHERE is_active = 1");
        $stmt->execute([]);
    }
    return (int)$stmt->fetchColumn();
}

// ============================================================
// CONTACTS HELPERS
// ============================================================

function saveContact(array $data): bool {
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO contacts (name, email, phone, subject, message, ip_address)
                          VALUES (?, ?, ?, ?, ?, ?)");
    return $stmt->execute([
        sanitize($data['name']   ?? ''),
        sanitize($data['email']  ?? ''),
        sanitize($data['phone']  ?? ''),
        sanitize($data['subject']?? ''),
        sanitize($data['message']?? ''),
        $_SERVER['REMOTE_ADDR'] ?? ''
    ]);
}

// ============================================================
// UTILITY HELPERS
// ============================================================

function sanitize(string $input): string {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

function redirect(string $url): void {
    header("Location: $url");
    exit;
}

function isPost(): bool {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function getYoutubeThumbnail(string $youtubeId): string {
    return "https://img.youtube.com/vi/{$youtubeId}/hqdefault.jpg";
}

function getYoutubeEmbedUrl(string $youtubeId): string {
    return "https://www.youtube.com/embed/{$youtubeId}";
}

function timeAgo(string $datetime): string {
    $time = time() - strtotime($datetime);
    if ($time < 60) return 'abhi abhi';
    if ($time < 3600) return floor($time/60) . ' min pehle';
    if ($time < 86400) return floor($time/3600) . ' ghante pehle';
    if ($time < 604800) return floor($time/86400) . ' din pehle';
    return date('d M Y', strtotime($datetime));
}

function csrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrf(): bool {
    return isset($_POST['csrf_token']) && $_POST['csrf_token'] === ($_SESSION['csrf_token'] ?? '');
}

function flashMessage(string $type, string $msg): void {
    $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
}

function getFlash(): ?array {
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}
