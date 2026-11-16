<?php
// ============================================================
// TechnicalBabaOffice - Contact Page
// ============================================================
$pageTitle = 'Contact Us - Technical Baba | Hum se Samparkit Karo';
require_once 'includes/header.php';

$mapsEmbed = $settings['maps_embed_url'] ?? '';
// Actual Google Maps embed from the provided link location
$mapsEmbed = 'https://maps.google.com/maps?q=TechnicalBabaOffice&output=embed&z=15';
?>

<!-- ==================== PAGE HERO ==================== -->
<section class="tb-page-hero">
  <div class="container">
    <div class="tb-breadcrumb">
      <a href="<?= SITE_URL ?>/">Home</a>
      <i class="fa-solid fa-chevron-right"></i>
      <span>Contact / Sampark</span>
    </div>
    <h1>📬 Hum se Baat Karo</h1>
    <p class="mt-2">Koi sawaal? Collaboration? Ya bas "Hello"? — Humein likho, hum zaroor jawab denge! 😊</p>
  </div>
</section>

<!-- ==================== CONTACT CONTENT ==================== -->
<section class="py-5">
  <div class="container">
    <div class="row g-4">

      <!-- Contact Form (LEFT) -->
      <div class="col-lg-7">
        <div class="tb-contact-card">
          <h3 class="mb-1">Message Bhejo <i class="fa-solid fa-paper-plane ms-1" style="color:var(--tb-primary)"></i></h3>
          <p class="text-muted mb-4">Hum 24 ghante ke andar reply karte hain.</p>

          <!-- Alert Div (filled by JS) -->
          <div id="contactAlert" class="tb-alert" style="display:none"></div>

          <form id="contactForm" novalidate>
            <input type="hidden" name="csrf_token" value="<?= csrfToken() ?>">

            <div class="row g-3">
              <div class="col-md-6">
                <label class="tb-form-label" for="name">
                  <i class="fa-solid fa-user me-1 text-muted"></i> Aapka Naam *
                </label>
                <input type="text" id="name" name="name" class="tb-form-control"
                       placeholder="e.g. Rahul Kumar" required maxlength="150">
              </div>
              <div class="col-md-6">
                <label class="tb-form-label" for="email">
                  <i class="fa-solid fa-envelope me-1 text-muted"></i> Email Address *
                </label>
                <input type="email" id="email" name="email" class="tb-form-control"
                       placeholder="rahul@example.com" required maxlength="150">
              </div>
              <div class="col-md-6">
                <label class="tb-form-label" for="phone">
                  <i class="fa-solid fa-phone me-1 text-muted"></i> Phone Number
                </label>
                <input type="tel" id="phone" name="phone" class="tb-form-control"
                       placeholder="+91 98765 43210" maxlength="20">
              </div>
              <div class="col-md-6">
                <label class="tb-form-label" for="subject">
                  <i class="fa-solid fa-tag me-1 text-muted"></i> Subject / Vishay
                </label>
                <input type="text" id="subject" name="subject" class="tb-form-control"
                       placeholder="e.g. Collaboration, Query..." maxlength="300">
              </div>
              <div class="col-12">
                <label class="tb-form-label" for="message">
                  <i class="fa-solid fa-message me-1 text-muted"></i> Message / Sandesh *
                </label>
                <textarea id="message" name="message" class="tb-form-control"
                          rows="6" placeholder="Aapka message yahaan likho..." required maxlength="2000"></textarea>
                <div class="text-end mt-1">
                  <small class="text-muted" id="msgCount">0 / 2000</small>
                </div>
              </div>
              <div class="col-12">
                <button type="submit" class="btn tb-btn-primary btn-lg w-100">
                  <i class="fa-solid fa-paper-plane me-2"></i> Message Bhejo!
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Contact Info (RIGHT) -->
      <div class="col-lg-5">
        <div class="tb-contact-info-card">
          <h3 class="mb-4" style="color:white">Sampark Ki Jankari <i class="fa-solid fa-address-card ms-2" style="color:var(--tb-primary)"></i></h3>

          <div class="tb-contact-info-item">
            <div class="tb-contact-info-icon"><i class="fa-solid fa-envelope"></i></div>
            <div class="tb-contact-info-text">
              <h5>Email</h5>
              <a href="mailto:<?= htmlspecialchars($settings['contact_email'] ?? '') ?>">
                <?= htmlspecialchars($settings['contact_email'] ?? 'contact@technicalbaba.com') ?>
              </a>
            </div>
          </div>

          <div class="tb-contact-info-item">
            <div class="tb-contact-info-icon"><i class="fa-solid fa-phone"></i></div>
            <div class="tb-contact-info-text">
              <h5>Phone / Mobile</h5>
              <a href="tel:<?= htmlspecialchars($settings['contact_phone'] ?? '') ?>">
                <?= htmlspecialchars($settings['contact_phone'] ?? '+91 98765 43210') ?>
              </a>
            </div>
          </div>

          <div class="tb-contact-info-item">
            <div class="tb-contact-info-icon"><i class="fa-solid fa-location-dot"></i></div>
            <div class="tb-contact-info-text">
              <h5>Address / Pata</h5>
              <p><?= htmlspecialchars($settings['contact_address'] ?? 'TechnicalBabaOffice, India') ?></p>
            </div>
          </div>

          <div class="tb-contact-info-item">
            <div class="tb-contact-info-icon"><i class="fa-solid fa-clock"></i></div>
            <div class="tb-contact-info-text">
              <h5>Response Time / Jawab Ka Samay</h5>
              <p>24 ghante ke andar hum reply karte hain 🙏</p>
            </div>
          </div>

          <!-- Social Links -->
          <h5 style="color:white;margin-top:28px;margin-bottom:16px">Social Media Par Milein</h5>
          <div class="tb-social-links">
            <?php if (!empty($settings['youtube_channel'])): ?>
              <a href="<?= htmlspecialchars($settings['youtube_channel']) ?>" target="_blank"
                 class="tb-social-link youtube" title="YouTube">
                <i class="fa-brands fa-youtube"></i>
              </a>
            <?php endif; ?>
            <?php if (!empty($settings['facebook_url'])): ?>
              <a href="<?= htmlspecialchars($settings['facebook_url']) ?>" target="_blank"
                 class="tb-social-link facebook" title="Facebook">
                <i class="fa-brands fa-facebook-f"></i>
              </a>
            <?php endif; ?>
            <?php if (!empty($settings['instagram_url'])): ?>
              <a href="<?= htmlspecialchars($settings['instagram_url']) ?>" target="_blank"
                 class="tb-social-link instagram" title="Instagram">
                <i class="fa-brands fa-instagram"></i>
              </a>
            <?php endif; ?>
            <?php if (!empty($settings['twitter_url'])): ?>
              <a href="<?= htmlspecialchars($settings['twitter_url']) ?>" target="_blank"
                 class="tb-social-link twitter" title="Twitter / X">
                <i class="fa-brands fa-x-twitter"></i>
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>

    </div><!-- .row -->

    <!-- Google Map -->
    <div class="mt-5">
      <h3 class="mb-3 text-center">Humari Location 📍</h3>
      <div class="tb-contact-map">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3!2d77.209023!3d28.613939!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjjCsDM2JzUwLjIiTiA3N8KwMTInMzIuNSJF!5e0!3m2!1sen!2sin!4v1234567890"
          width="100%" height="420" style="border:0;" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade" title="Technical Baba Office Location">
        </iframe>
      </div>
      <p class="text-center text-muted mt-2 small">
        <i class="fa-solid fa-location-dot text-danger me-1"></i>
        <a href="https://maps.app.goo.gl/YxVzxAthUP8LvEhQ6" target="_blank" class="text-muted">
          Google Maps par Dekho →
        </a>
      </p>
    </div>

  </div>
</section>

<script>
// Character counter for message textarea
document.addEventListener('DOMContentLoaded', function() {
  const msg = document.getElementById('message');
  const count = document.getElementById('msgCount');
  if (msg && count) {
    msg.addEventListener('input', function() {
      count.textContent = this.value.length + ' / 2000';
      count.style.color = this.value.length > 1800 ? '#dc3545' : '';
    });
  }
});
</script>

<?php require_once 'includes/footer.php'; ?>
