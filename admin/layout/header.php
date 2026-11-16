<?php
// ============================================================
// TechnicalBabaOffice - Admin Header (AdminLTE 3)
// ============================================================
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../auth.php';

if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}

requireAdminAuth();

$adminUser    = getCurrentAdmin();
$adminTitle   = $pageTitle ?? 'Dashboard';
$siteName     = getSetting('site_name', 'Technical Baba');
$flash        = getFlash();

$menuItems = [
    ['url' => 'dashboard.php',  'icon' => 'tachometer-alt', 'label' => 'Dashboard'],
    ['url' => 'services.php',   'icon' => 'list-alt',       'label' => 'Services / Categories'],
    ['url' => 'videos.php',     'icon' => 'video',          'label' => 'Videos'],
    ['url' => 'contacts.php',   'icon' => 'envelope',       'label' => 'Messages / Contacts'],
    ['url' => 'settings.php',   'icon' => 'cog',            'label' => 'Site Settings'],
];

$currentFile = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf" content="<?= csrfToken() ?>">
  <title><?= htmlspecialchars($adminTitle) ?> | <?= htmlspecialchars($siteName) ?> Admin</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- AdminLTE 3 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">

  <!-- Bootstrap 4 (AdminLTE uses Bootstrap 4) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/css/bootstrap.min.css">

  <!-- Admin Custom CSS -->
  <link rel="stylesheet" href="<?= ADMIN_URL ?>/admin.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- ==================== NAVBAR ==================== -->
  <nav class="main-header navbar navbar-expand navbar-dark" style="background:#0d1b2a;border-bottom:1px solid rgba(255,255,255,0.08)">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
          <i class="fas fa-bars"></i>
        </a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?= SITE_URL ?>/" target="_blank" class="nav-link text-muted">
          <i class="fas fa-external-link-alt me-1"></i> View Website
        </a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <div class="d-flex align-items-center gap-2">
            <div style="width:32px;height:32px;background:linear-gradient(135deg,#ff6600,#ff9500);
                        border-radius:50%;display:flex;align-items:center;justify-content:center;
                        font-weight:700;font-size:0.85rem;color:white">
              <?= strtoupper(substr($adminUser['full_name'] ?? 'A', 0, 1)) ?>
            </div>
            <span class="d-none d-md-inline" style="color:rgba(255,255,255,0.8);font-size:0.875rem">
              <?= htmlspecialchars($adminUser['full_name'] ?? 'Admin') ?>
            </span>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <a href="settings.php" class="dropdown-item"><i class="fas fa-cog mr-2"></i>Settings</a>
          <div class="dropdown-divider"></div>
          <a href="logout.php" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
        </div>
      </li>
    </ul>
  </nav>

  <!-- ==================== SIDEBAR ==================== -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background:#0d1b2a!important">

    <!-- Brand -->
    <a href="dashboard.php" class="brand-link" style="border-bottom:1px solid rgba(255,255,255,0.08)">
      <div style="width:36px;height:36px;background:linear-gradient(135deg,#ff6600,#ff9500);
                  border-radius:9px;display:inline-flex;align-items:center;justify-content:center;
                  font-weight:900;font-size:0.9rem;color:white;margin-right:10px;flex-shrink:0">TB</div>
      <span class="brand-text font-weight-bold"><?= htmlspecialchars($siteName) ?></span>
      <small style="color:rgba(255,255,255,0.3);display:block;font-size:0.65rem;margin-top:-2px">Admin Panel</small>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- User Panel -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex"
           style="border-bottom:1px solid rgba(255,255,255,0.08)">
        <div class="image">
          <div style="width:34px;height:34px;background:linear-gradient(135deg,#ff6600,#ff9500);
                      border-radius:50%;display:flex;align-items:center;justify-content:center;
                      font-weight:700;font-size:0.9rem;color:white">
            <?= strtoupper(substr($adminUser['full_name'] ?? 'A', 0, 1)) ?>
          </div>
        </div>
        <div class="info">
          <a href="settings.php" class="d-block" style="color:rgba(255,255,255,0.9)">
            <?= htmlspecialchars($adminUser['full_name'] ?? 'Admin') ?>
          </a>
          <small style="color:#ff6600;font-size:0.7rem">● Online</small>
        </div>
      </div>

      <!-- Nav Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
          <?php foreach ($menuItems as $item): ?>
            <li class="nav-item">
              <a href="<?= htmlspecialchars($item['url']) ?>"
                 class="nav-link <?= $currentFile === $item['url'] ? 'active' : '' ?>">
                <i class="nav-icon fas fa-<?= htmlspecialchars($item['icon']) ?>"></i>
                <p><?= htmlspecialchars($item['label']) ?></p>
              </a>
            </li>
          <?php endforeach; ?>
          <li class="nav-item mt-3" style="border-top:1px solid rgba(255,255,255,0.05);padding-top:8px">
            <a href="logout.php" class="nav-link" style="color:rgba(255,80,80,0.8)">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Logout</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- ==================== CONTENT WRAPPER ==================== -->
  <div class="content-wrapper">

    <!-- Content Header -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?= htmlspecialchars($adminTitle) ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active"><?= htmlspecialchars($adminTitle) ?></li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Flash Messages -->
    <?php if ($flash): ?>
      <div class="container-fluid px-3">
        <div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show">
          <i class="fas fa-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?> mr-2"></i>
          <?= htmlspecialchars($flash['msg']) ?>
          <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
      </div>
    <?php endif; ?>

    <!-- Main Content -->
    <section class="content">
      <div class="container-fluid">
