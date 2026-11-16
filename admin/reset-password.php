<?php
// ============================================================
// TechnicalBabaOffice - Admin Password Reset
// ============================================================
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

session_name(SESSION_NAME);
session_start();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrf()) {
        $error = 'Security check failed. Please reload the page.';
    } else {
        $username        = trim($_POST['username'] ?? '');
        $new_password    = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($username)) {
            $error = 'Admin Username ya Email enter karein.';
        } elseif (empty($new_password) || strlen($new_password) < 6) {
            $error = 'Naya password kam se kam 6 characters ka hona chahiye.';
        } elseif ($new_password !== $confirm_password) {
            $error = 'Dono passwords match nahi kar rahe hain.';
        } else {
            $db = getDB();
            // Check if user exists by username OR email
            $stmt = $db->prepare("SELECT * FROM admin_users WHERE username = ? OR email = ? LIMIT 1");
            $stmt->execute([$username, $username]);
            $admin = $stmt->fetch();

            if (!$admin) {
                $error = 'Yeh admin user database mein nahi mila. Please sahi username dalein.';
            } else {
                $newHash = password_hash($new_password, PASSWORD_BCRYPT);
                $update = $db->prepare("UPDATE admin_users SET password = ?, updated_at = NOW() WHERE id = ?");
                $update->execute([$newHash, $admin['id']]);

                $success = 'Password successfully reset ho gaya hai! Ab aap naye password ke saath login kar sakte hain.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password | Technical Baba Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/style.css">
  <style>
    body { background: linear-gradient(135deg, #0d1b2a 0%, #0a1628 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
  </style>
</head>
<body>

<div class="tb-login-card">
  <div class="tb-login-logo">
    <div class="tb-login-logo-icon"><i class="fa-solid fa-key"></i></div>
    <h2 class="tb-login-title">Password Reset</h2>
    <p class="tb-login-subtitle">Technical Baba Master Admin</p>
  </div>

  <?php if ($error): ?>
    <div class="tb-alert tb-alert-error">
      <i class="fa-solid fa-circle-exclamation me-2"></i><?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div class="tb-alert tb-alert-success">
      <i class="fa-solid fa-circle-check me-2"></i><?= htmlspecialchars($success) ?>
    </div>
    <div class="mt-3">
      <a href="<?= admin_url('login') ?>" class="btn tb-btn-primary w-100 py-3">
        <i class="fa-solid fa-right-to-bracket me-2"></i> Login Page Par Jao
      </a>
    </div>
  <?php else: ?>
    <form method="POST" action="<?= admin_url('reset-password') ?>" class="tb-login-form" novalidate>
      <input type="hidden" name="csrf_token" value="<?= csrfToken() ?>">

      <div class="mb-3">
        <label class="tb-form-label" for="username">
          <i class="fa-solid fa-user me-1"></i> Admin Username ya Email
        </label>
        <input type="text" id="username" name="username" class="tb-form-control" required autofocus
               placeholder="admin" value="<?= htmlspecialchars($_POST['username'] ?? 'admin') ?>">
      </div>

      <div class="mb-3">
        <label class="tb-form-label" for="new_password">
          <i class="fa-solid fa-lock me-1"></i> Naya Password
        </label>
        <div style="position:relative">
          <input type="password" id="new_password" name="new_password" class="tb-form-control" required
                 placeholder="Min. 6 characters">
          <button type="button" onclick="togglePwd('new_password', 'eyeIcon1')"
                  style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:rgba(255,255,255,0.4);cursor:pointer;padding:0">
            <i class="fa-solid fa-eye" id="eyeIcon1"></i>
          </button>
        </div>
      </div>

      <div class="mb-3">
        <label class="tb-form-label" for="confirm_password">
          <i class="fa-solid fa-shield-halved me-1"></i> Confirm Naya Password
        </label>
        <div style="position:relative">
          <input type="password" id="confirm_password" name="confirm_password" class="tb-form-control" required
                 placeholder="Wahi password dobara dalein">
          <button type="button" onclick="togglePwd('confirm_password', 'eyeIcon2')"
                  style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:rgba(255,255,255,0.4);cursor:pointer;padding:0">
            <i class="fa-solid fa-eye" id="eyeIcon2"></i>
          </button>
        </div>
      </div>

      <button type="submit" class="btn tb-btn-primary w-100 py-3 mt-2" style="font-size:1rem">
        <i class="fa-solid fa-rotate me-2"></i> Password Update / Reset Karein
      </button>

      <div class="text-center mt-4 d-flex justify-content-between">
        <a href="<?= admin_url('login') ?>" style="color:var(--tb-primary);font-size:0.85rem;text-decoration:none">
          <i class="fa-solid fa-arrow-left me-1"></i> Login Par Jao
        </a>
        <a href="<?= url() ?>" style="color:rgba(255,255,255,0.4);font-size:0.85rem;text-decoration:none">
          Website Dekho
        </a>
      </div>
    </form>
  <?php endif; ?>
</div>

<script>
function togglePwd(inputId, iconId) {
  const inp = document.getElementById(inputId);
  const icon = document.getElementById(iconId);
  if (inp.type === 'password') {
    inp.type = 'text';
    icon.className = 'fa-solid fa-eye-slash';
  } else {
    inp.type = 'password';
    icon.className = 'fa-solid fa-eye';
  }
}
</script>
</body>
</html>
