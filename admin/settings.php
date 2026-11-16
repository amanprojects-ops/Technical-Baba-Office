<?php
// ============================================================
// TechnicalBabaOffice - Admin: Site Settings
// ============================================================
$pageTitle = 'Site Settings';
require_once '../layout/header.php';

// --- Handle Save ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = [
        'site_name', 'site_tagline', 'hero_title', 'hero_subtitle',
        'hero_cta_text', 'hero_cta_url', 'about_text',
        'youtube_channel', 'facebook_url', 'instagram_url', 'twitter_url',
        'contact_email', 'contact_phone', 'contact_address',
        'subscriber_count', 'video_count', 'views_count',
    ];
    foreach ($fields as $f) {
        if (isset($_POST[$f])) {
            updateSetting($f, sanitize($_POST[$f]));
        }
    }
    flashMessage('success', '✅ Settings saved successfully!');
    redirect(ADMIN_URL . '/settings.php');
}

$s = getAllSettings();
?>

<div class="row">
  <div class="col-12">
    <form method="POST" action="settings.php">
      <div class="row">

        <!-- LEFT: General Settings -->
        <div class="col-lg-6">

          <!-- General -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-globe mr-2"></i>General Settings</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label>Site Name / Website Ka Naam</label>
                <input type="text" name="site_name" class="form-control"
                       value="<?= htmlspecialchars($s['site_name'] ?? '') ?>" required>
              </div>
              <div class="form-group">
                <label>Tagline / Slogan</label>
                <input type="text" name="site_tagline" class="form-control"
                       value="<?= htmlspecialchars($s['site_tagline'] ?? '') ?>">
              </div>
              <div class="form-group">
                <label>About Text</label>
                <textarea name="about_text" class="form-control" rows="4"><?= htmlspecialchars($s['about_text'] ?? '') ?></textarea>
              </div>
            </div>
          </div>

          <!-- Hero Section -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-home mr-2"></i>Hero Section</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label>Hero Title (use \n for new line)</label>
                <input type="text" name="hero_title" class="form-control"
                       value="<?= htmlspecialchars($s['hero_title'] ?? '') ?>">
              </div>
              <div class="form-group">
                <label>Hero Subtitle</label>
                <textarea name="hero_subtitle" class="form-control" rows="3"><?= htmlspecialchars($s['hero_subtitle'] ?? '') ?></textarea>
              </div>
              <div class="form-row">
                <div class="form-group col-6">
                  <label>CTA Button Text</label>
                  <input type="text" name="hero_cta_text" class="form-control"
                         value="<?= htmlspecialchars($s['hero_cta_text'] ?? '') ?>">
                </div>
                <div class="form-group col-6">
                  <label>CTA Button URL</label>
                  <input type="url" name="hero_cta_url" class="form-control"
                         value="<?= htmlspecialchars($s['hero_cta_url'] ?? '') ?>">
                </div>
              </div>
            </div>
          </div>

          <!-- Stats -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i>Stats Numbers</h3>
            </div>
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-4">
                  <label>Subscribers</label>
                  <input type="text" name="subscriber_count" class="form-control"
                         value="<?= htmlspecialchars($s['subscriber_count'] ?? '') ?>" placeholder="e.g. 1 Lakh+">
                </div>
                <div class="form-group col-4">
                  <label>Videos</label>
                  <input type="text" name="video_count" class="form-control"
                         value="<?= htmlspecialchars($s['video_count'] ?? '') ?>" placeholder="e.g. 500+">
                </div>
                <div class="form-group col-4">
                  <label>Total Views</label>
                  <input type="text" name="views_count" class="form-control"
                         value="<?= htmlspecialchars($s['views_count'] ?? '') ?>" placeholder="e.g. 1 Crore+">
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- RIGHT: Social + Contact -->
        <div class="col-lg-6">

          <!-- Social Media -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-share-alt mr-2"></i>Social Media Links</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label><i class="fab fa-youtube text-danger mr-1"></i>YouTube Channel URL</label>
                <input type="url" name="youtube_channel" class="form-control"
                       value="<?= htmlspecialchars($s['youtube_channel'] ?? '') ?>"
                       placeholder="https://youtube.com/@YourChannel">
              </div>
              <div class="form-group">
                <label><i class="fab fa-facebook-f text-primary mr-1"></i>Facebook URL</label>
                <input type="url" name="facebook_url" class="form-control"
                       value="<?= htmlspecialchars($s['facebook_url'] ?? '') ?>">
              </div>
              <div class="form-group">
                <label><i class="fab fa-instagram text-danger mr-1"></i>Instagram URL</label>
                <input type="url" name="instagram_url" class="form-control"
                       value="<?= htmlspecialchars($s['instagram_url'] ?? '') ?>">
              </div>
              <div class="form-group">
                <label><i class="fab fa-x-twitter mr-1"></i>Twitter / X URL</label>
                <input type="url" name="twitter_url" class="form-control"
                       value="<?= htmlspecialchars($s['twitter_url'] ?? '') ?>">
              </div>
            </div>
          </div>

          <!-- Contact Info -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-address-card mr-2"></i>Contact Information</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label><i class="fas fa-envelope text-muted mr-1"></i>Email</label>
                <input type="email" name="contact_email" class="form-control"
                       value="<?= htmlspecialchars($s['contact_email'] ?? '') ?>">
              </div>
              <div class="form-group">
                <label><i class="fas fa-phone text-muted mr-1"></i>Phone</label>
                <input type="text" name="contact_phone" class="form-control"
                       value="<?= htmlspecialchars($s['contact_phone'] ?? '') ?>">
              </div>
              <div class="form-group">
                <label><i class="fas fa-location-dot text-muted mr-1"></i>Address</label>
                <textarea name="contact_address" class="form-control" rows="3"><?= htmlspecialchars($s['contact_address'] ?? '') ?></textarea>
              </div>
            </div>
          </div>

        </div>
      </div><!-- .row -->

      <!-- Save Button -->
      <div class="row">
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-lg btn-block mb-4">
            <i class="fas fa-save mr-2"></i> Save All Settings
          </button>
        </div>
      </div>

    </form>
  </div>
</div>

<?php require_once '../layout/footer.php'; ?>
