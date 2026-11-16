<?php
// ============================================================
// TechnicalBabaOffice - Admin Login Page
// ============================================================
require_once '../config/db.php';
require_once '../includes/functions.php';

session_name(SESSION_NAME);
session_start();

// If already logged in, redirect
if (!empty($_SESSION[ADMIN_SESSION_KEY])) {
    redirect(ADMIN_URL . '/dashboard.php');
}

$error = '';

// --- Handle Login ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!verifyCsrf()) {
        $error = 'Security check failed. Please refresh the page.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $error = 'Username aur password dono daalo.';
        } else {
            $db = getDB();
            $stmt = $db->prepare("SELECT * FROM admin_users WHERE username = ? LIMIT 1");
            $stmt->execute([$username]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($password, $admin['password'])) {
                // Success
                session_regenerate_id(true);
                $_SESSION[ADMIN_SESSION_KEY] = true;
                $_SESSION['admin_id']        = $admin['id'];
                $_SESSION['admin_username']  = $admin['username'];

                $redirectTo = $_GET['redirect'] ?? (ADMIN_URL . '/dashboard.php');
                redirect($redirectTo);
            } else {
                $error = 'Galat username ya password. Dobara try karo!';
                // Simple brute-force delay
                sleep(1);
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
  <title>Admin Login | Technical Baba</title>
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
    <div class="tb-login-logo-icon">TB</div>
    <h2 class="tb-login-title">Admin Login</h2>
    <p class="tb-login-subtitle">Technical Baba Admin Panel</p>
  </div>

  <?php if ($error): ?>
    <div class="tb-alert tb-alert-error">
      <i class="fa-solid fa-circle-exclamation me-2"></i><?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>

  <form method="POST" action="login.php<?= !empty($_GET['redirect']) ? '?redirect='.urlencode($_GET['redirect']) : '' ?>" class="tb-login-form" novalidate>
    <input type="hidden" name="csrf_token" value="<?= csrfToken() ?>">

    <div class="mb-3">
      <label class="tb-form-label" for="username">
        <i class="fa-solid fa-user me-1"></i> Username
      </label>
      <input type="text" id="username" name="username" class="tb-form-control" required autofocus
             placeholder="admin" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" autocomplete="username">
    </div>

    <div class="mb-3">
      <label class="tb-form-label" for="password">
        <i class="fa-solid fa-lock me-1"></i> Password
      </label>
      <div style="position:relative">
        <input type="password" id="password" name="password" class="tb-form-control" required
               placeholder="••••••••" autocomplete="current-password">
        <button type="button" onclick="togglePwd()" id="eyeBtn"
                style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:rgba(255,255,255,0.4);cursor:pointer;padding:0">
          <i class="fa-solid fa-eye" id="eyeIcon"></i>
        </button>
      </div>
    </div>

    <button type="submit" class="btn tb-btn-primary w-100 py-3 mt-2" style="font-size:1rem">
      <i class="fa-solid fa-right-to-bracket me-2"></i> Login Karo
    </button>

    <div class="text-center mt-4">
      <a href="<?= SITE_URL ?>/" style="color:rgba(255,255,255,0.3);font-size:0.8rem;text-decoration:none">
        <i class="fa-solid fa-arrow-left me-1"></i> Website par wapas jao
      </a>
    </div>
  </form>
</div>

<script>
function togglePwd() {
  const inp = document.getElementById('password');
  const icon = document.getElementById('eyeIcon');
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
