<?php
// ============================================================
// TechnicalBabaOffice - Public Header
// ============================================================
require_once __DIR__ . '/../includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}

$settings = getAllSettings();
$siteName = $settings['site_name'] ?? 'Technical Baba';
$siteTagline = $settings['site_tagline'] ?? 'Tech Seekho, Aage Badho!';

// Get current page for active nav
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="hi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($siteTagline) ?> - Technology tutorials in Hindi & English.">
  <meta name="keywords" content="Technical Baba, Tech tutorials Hindi, Technology in Hindi, YouTube tech">
  <meta name="author" content="Technical Baba">
  <title><?= htmlspecialchars($pageTitle ?? $siteName) ?></title>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="<?= ASSETS_URL ?>/images/favicon.ico">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- Bootstrap 5 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">

  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/style.css">
</head>
<body>

<!-- ==================== PRELOADER ==================== -->
<div id="preloader">
  <div class="preloader-inner">
    <div class="preloader-logo">TB</div>
    <div class="preloader-spinner"></div>
  </div>
</div>

<!-- ==================== NAVBAR ==================== -->
<nav class="navbar navbar-expand-lg navbar-dark tb-navbar fixed-top" id="mainNav">
  <div class="container">

    <!-- Brand Logo -->
    <a class="navbar-brand tb-brand" href="<?= SITE_URL ?>/">
      <div class="tb-logo-icon">TB</div>
      <span class="tb-brand-text">
        <?= htmlspecialchars($siteName) ?>
        <small><?= htmlspecialchars($siteTagline) ?></small>
      </span>
    </a>

    <!-- Mobile Toggle -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Nav Links -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
        <li class="nav-item">
          <a class="nav-link <?= $currentPage === 'index' ? 'active' : '' ?>" href="<?= SITE_URL ?>/">
            <i class="fa-solid fa-house me-1"></i> Home
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $currentPage === 'services' ? 'active' : '' ?>" href="<?= SITE_URL ?>/services.php">
            <i class="fa-solid fa-video me-1"></i> Videos & Services
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $currentPage === 'contact' ? 'active' : '' ?>" href="<?= SITE_URL ?>/contact.php">
            <i class="fa-solid fa-envelope me-1"></i> Contact
          </a>
        </li>
        <li class="nav-item ms-lg-2">
          <a class="btn tb-btn-youtube" href="<?= htmlspecialchars($settings['youtube_channel'] ?? '#') ?>" target="_blank">
            <i class="fa-brands fa-youtube me-1"></i> YouTube
          </a>
        </li>
      </ul>
    </div>

  </div>
</nav>
<!-- End Navbar -->
