<?php
// ============================================================
// TechnicalBabaOffice - 404 Not Found Page
// ============================================================
http_response_code(404);
$pageTitle = '404 - Page Not Found | Technical Baba';
require_once 'includes/header.php';
?>

<section style="min-height:70vh;display:flex;align-items:center;justify-content:center;padding-top:var(--navbar-height)">
  <div class="container text-center py-5">
    <div style="font-size:6rem;line-height:1">😵</div>
    <h1 class="mt-3" style="font-size:5rem;font-weight:900;color:var(--tb-primary)">404</h1>
    <h2 style="color:var(--tb-dark)">Yeh Page Nahi Mila! / Page Not Found</h2>
    <p class="text-muted mt-2 mb-4" style="font-size:1.1rem">
      Aap jo page dhundh rahe the, woh yahaan nahi hai.<br>
      Shayad URL change ho gaya ya delete ho gaya.
    </p>
    <div class="d-flex flex-wrap gap-3 justify-content-center">
      <a href="<?= SITE_URL ?>/" class="btn tb-btn-primary btn-lg">
        <i class="fa-solid fa-house me-2"></i> Home Par Jao
      </a>
      <a href="<?= SITE_URL ?>/services.php" class="btn tb-btn-secondary btn-lg">
        <i class="fa-solid fa-video me-2"></i> Videos Dekho
      </a>
      <a href="<?= SITE_URL ?>/contact.php" class="btn tb-btn-outline-light btn-lg" style="border-color:#ccc;color:#666">
        <i class="fa-solid fa-envelope me-2"></i> Contact Karo
      </a>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
