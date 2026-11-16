<?php
// ============================================================
// TechnicalBabaOffice - Contact Form Handler (AJAX)
// ============================================================
require_once 'config/db.php';
require_once 'includes/functions.php';

session_name(SESSION_NAME);
session_start();

header('Content-Type: application/json; charset=utf-8');

// Only allow POST
if (!isPost()) {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}

// CSRF check
if (!verifyCsrf()) {
    echo json_encode(['success' => false, 'message' => 'Security check failed. Page reload karein.']);
    exit;
}

// Collect + validate
$name    = trim($_POST['name']    ?? '');
$email   = trim($_POST['email']   ?? '');
$phone   = trim($_POST['phone']   ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

$errors = [];

if (empty($name) || mb_strlen($name) < 2) {
    $errors[] = 'Naam sahi se daalo (kam se kam 2 characters).';
}
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Sahi email address daalo.';
}
if (empty($message) || mb_strlen($message) < 10) {
    $errors[] = 'Message kuch zyada detail mein likho (kam se kam 10 characters).';
}
if (mb_strlen($message) > 2000) {
    $errors[] = 'Message zyada lamba hai (max 2000 characters).';
}

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

// Save to DB
$saved = saveContact([
    'name'    => $name,
    'email'   => $email,
    'phone'   => $phone,
    'subject' => $subject,
    'message' => $message,
]);

if ($saved) {
    echo json_encode([
        'success' => true,
        'message' => '✅ Aapka message mil gaya! Hum jaldi jawab denge. Shukriya! 🙏'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Kuch galat ho gaya. Please dobara try karo.'
    ]);
}
