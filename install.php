<?php
// ============================================================
// TechnicalBabaOffice - One-Click Database Installer
// ============================================================
require_once __DIR__ . '/config/db.php';

$message = '';
$status  = '';
$installed = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['auto'])) {
    try {
        // Connect to MySQL server without selecting database first
        $pdo = new PDO("mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $schemaFile = __DIR__ . '/database/schema.sql';
        if (!file_exists($schemaFile)) {
            throw new Exception("schema.sql file not found at: $schemaFile");
        }

        $sql = file_get_contents($schemaFile);
        $pdo->exec($sql);

        $installed = true;
        $status = 'success';
        $message = "Database `technicalbaba_db` and tables created and seeded successfully!";
    } catch (Exception $e) {
        $status = 'error';
        $message = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Setup & Installer | Technical Baba</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
  <style>
    body { background: #0d1b2a; color: #fff; font-family: 'Inter', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
    .install-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 40px; max-width: 580px; width: 100%; backdrop-filter: blur(10px); }
    .btn-tb { background: linear-gradient(135deg, #ff6600, #ff9500); border: none; color: #fff; font-weight: 600; padding: 12px 24px; border-radius: 8px; }
    .btn-tb:hover { color: #fff; opacity: 0.95; }
    .brand-badge { width: 50px; height: 50px; background: linear-gradient(135deg, #ff6600, #ff9500); border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.2rem; }
  </style>
</head>
<body>

<div class="install-card shadow-lg">
  <div class="text-center mb-4">
    <div class="brand-badge mb-3">TB</div>
    <h3 class="fw-bold mb-1">Technical Baba Setup</h3>
    <p class="text-white-50 small">One-Click Database Installer & Configurator</p>
  </div>

  <?php if ($status === 'success'): ?>
    <div class="alert alert-success">
      <h5 class="fw-bold mb-1">🎉 Installation Successful!</h5>
      <p class="mb-2"><?= htmlspecialchars($message) ?></p>
      <hr>
      <div class="small">
        <strong>Default Admin Credentials:</strong><br>
        Username: <code>admin</code><br>
        Password: <code>admin@123</code>
      </div>
    </div>
    <div class="d-grid gap-2 mt-4">
      <a href="<?= SITE_URL ?>/admin/login.php" class="btn btn-tb">Go to Admin Login →</a>
      <a href="<?= SITE_URL ?>/" class="btn btn-outline-light">Visit Website 🌐</a>
    </div>
  <?php elseif ($status === 'error'): ?>
    <div class="alert alert-danger">
      <h5 class="fw-bold mb-1">❌ Setup Error</h5>
      <p class="mb-0"><?= htmlspecialchars($message) ?></p>
    </div>
    <form method="POST" class="d-grid mt-3">
      <button type="submit" class="btn btn-tb">Try Again 🔄</button>
    </form>
  <?php else: ?>
    <div class="card bg-dark border-secondary p-3 mb-4 text-white-50 small">
      <div class="fw-bold text-white mb-2">Configuration Checklist:</div>
      <div>• Host: <code><?= DB_HOST ?></code></div>
      <div>• Database: <code><?= DB_NAME ?></code></div>
      <div>• User: <code><?= DB_USER ?></code></div>
      <div>• Site URL: <code><?= SITE_URL ?></code></div>
    </div>

    <form method="POST" class="d-grid gap-2">
      <button type="submit" class="btn btn-tb py-3">Install / Reset Database Now 🚀</button>
      <a href="<?= SITE_URL ?>/" class="btn btn-link text-white-50 text-decoration-none text-center">Cancel & Go to Homepage</a>
    </form>
  <?php endif; ?>
</div>

</body>
</html>
