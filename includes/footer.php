<?php
// ============================================================
// TechnicalBabaOffice - Public Footer
// ============================================================
?>

<!-- ==================== FOOTER ==================== -->
<footer class="tb-footer">
  <div class="container">
    <div class="row g-4">

      <!-- Brand Column -->
      <div class="col-lg-4 col-md-6">
        <div class="tb-footer-brand mb-3">
          <div class="tb-logo-icon-sm">TB</div>
          <span><?= htmlspecialchars($settings['site_name'] ?? 'Technical Baba') ?></span>
        </div>
        <p class="tb-footer-tagline"><?= htmlspecialchars($settings['site_tagline'] ?? '') ?></p>
        <p class="tb-footer-about"><?= htmlspecialchars($settings['about_text'] ?? '') ?></p>
        <!-- Social Links -->
        <div class="tb-social-links mt-3">
          <?php if (!empty($settings['youtube_channel'])): ?>
            <a href="<?= htmlspecialchars($settings['youtube_channel']) ?>" target="_blank" class="tb-social-link youtube" title="YouTube">
              <i class="fa-brands fa-youtube"></i>
            </a>
          <?php endif; ?>
          <?php if (!empty($settings['facebook_url'])): ?>
            <a href="<?= htmlspecialchars($settings['facebook_url']) ?>" target="_blank" class="tb-social-link facebook" title="Facebook">
              <i class="fa-brands fa-facebook-f"></i>
            </a>
          <?php endif; ?>
          <?php if (!empty($settings['instagram_url'])): ?>
            <a href="<?= htmlspecialchars($settings['instagram_url']) ?>" target="_blank" class="tb-social-link instagram" title="Instagram">
              <i class="fa-brands fa-instagram"></i>
            </a>
          <?php endif; ?>
          <?php if (!empty($settings['twitter_url'])): ?>
            <a href="<?= htmlspecialchars($settings['twitter_url']) ?>" target="_blank" class="tb-social-link twitter" title="Twitter / X">
              <i class="fa-brands fa-x-twitter"></i>
            </a>
          <?php endif; ?>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="col-lg-2 col-md-6">
        <h5 class="tb-footer-heading">Quick Links</h5>
        <ul class="tb-footer-links">
          <li><a href="<?= SITE_URL ?>/"><i class="fa-solid fa-chevron-right me-1"></i>Home</a></li>
          <li><a href="<?= SITE_URL ?>/services.php"><i class="fa-solid fa-chevron-right me-1"></i>Videos</a></li>
          <li><a href="<?= SITE_URL ?>/contact.php"><i class="fa-solid fa-chevron-right me-1"></i>Contact</a></li>
        </ul>
      </div>

      <!-- Services -->
      <div class="col-lg-3 col-md-6">
        <h5 class="tb-footer-heading">Services / Content</h5>
        <?php
        $footerServices = getActiveServices();
        ?>
        <ul class="tb-footer-links">
          <?php foreach (array_slice($footerServices, 0, 5) as $svc): ?>
            <li>
              <a href="<?= SITE_URL ?>/services.php?cat=<?= $svc['id'] ?>">
                <?= renderIcon($svc['icon'], 'me-1') ?>
                <?= htmlspecialchars($svc['title']) ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <!-- Contact Info -->
      <div class="col-lg-3 col-md-6">
        <h5 class="tb-footer-heading">Contact / Sampark</h5>
        <ul class="tb-footer-contact">
          <?php if (!empty($settings['contact_email'])): ?>
            <li>
              <i class="fa-solid fa-envelope"></i>
              <a href="mailto:<?= htmlspecialchars($settings['contact_email']) ?>">
                <?= htmlspecialchars($settings['contact_email']) ?>
              </a>
            </li>
          <?php endif; ?>
          <?php if (!empty($settings['contact_phone'])): ?>
            <li>
              <i class="fa-solid fa-phone"></i>
              <a href="tel:<?= htmlspecialchars($settings['contact_phone']) ?>">
                <?= htmlspecialchars($settings['contact_phone']) ?>
              </a>
            </li>
          <?php endif; ?>
          <?php if (!empty($settings['contact_address'])): ?>
            <li>
              <i class="fa-solid fa-location-dot"></i>
              <span><?= htmlspecialchars($settings['contact_address']) ?></span>
            </li>
          <?php endif; ?>
        </ul>
      </div>

    </div><!-- .row -->

    <!-- Footer Bottom -->
    <div class="tb-footer-bottom">
      <div class="row align-items-center">
        <div class="col-md-6">
          <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($settings['site_name'] ?? 'Technical Baba') ?>. All Rights Reserved.</p>
        </div>
        <div class="col-md-6 text-md-end">
          <p>Made with <i class="fa-solid fa-heart text-danger"></i> in India 🇮🇳</p>
        </div>
      </div>
    </div>

  </div>
</footer>
<!-- End Footer -->

<!-- Back to Top Button -->
<button class="tb-back-to-top" id="backToTop" title="Upar Jao">
  <i class="fa-solid fa-arrow-up"></i>
</button>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- Bootstrap 5 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="<?= ASSETS_URL ?>/js/main.js"></script>

</body>
</html>
