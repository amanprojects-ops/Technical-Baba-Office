<?php
// ============================================================
// TechnicalBabaOffice - Homepage (index.php)
// ============================================================
$pageTitle = 'Technical Baba - Tech Seekho, Aage Badho! 🚀';
require_once 'includes/header.php';

$featuredVideos = getFeaturedVideos(6);
$activeServices = getActiveServices();
?>

<!-- ==================== HERO SECTION ==================== -->
<section class="tb-hero" id="home">
  <div class="tb-hero-bg">
    <div class="tb-hero-particles" id="particles"></div>
    <div class="tb-hero-overlay"></div>
  </div>
  <div class="container">
    <div class="row align-items-center min-vh-100 py-5">
      <div class="col-lg-7 col-md-8">
        <div class="tb-hero-content animate__animated animate__fadeInUp">
          <div class="tb-hero-badge mb-3">
            <i class="fa-brands fa-youtube me-2"></i>
            <?= htmlspecialchars($settings['subscriber_count'] ?? '1 Lakh+') ?> Subscribers
          </div>
          <h1 class="tb-hero-title">
            <?php
            $heroTitle = $settings['hero_title'] ?? 'Technical Baba ke saath Sikho, Badhao, Jito!';
            $parts = explode("\n", $heroTitle, 2);
            echo htmlspecialchars($parts[0]);
            if (isset($parts[1])) {
                echo '<br><span class="tb-gradient-text">' . htmlspecialchars($parts[1]) . '</span>';
            }
            ?>
          </h1>
          <p class="tb-hero-subtitle mt-3">
            <?= htmlspecialchars($settings['hero_subtitle'] ?? '') ?>
          </p>
          <div class="tb-hero-actions mt-4 d-flex flex-wrap gap-3">
            <a href="services.php" class="btn tb-btn-primary btn-lg">
              <i class="fa-solid fa-play me-2"></i>
              <?= htmlspecialchars($settings['hero_cta_text'] ?? 'Videos Dekho') ?>
            </a>
            <a href="<?= htmlspecialchars($settings['youtube_channel'] ?? '#') ?>"
               target="_blank" class="btn tb-btn-outline-light btn-lg">
              <i class="fa-brands fa-youtube me-2"></i> YouTube Subscribe
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-5 col-md-4 d-none d-md-flex justify-content-center">
        <div class="tb-hero-visual animate__animated animate__fadeInRight">
          <div class="tb-hero-card">
            <div class="tb-hero-card-inner">
              <i class="fa-brands fa-youtube tb-hero-yt-icon"></i>
              <div class="tb-hero-stats-mini">
                <div class="tb-mini-stat">
                  <span class="num"><?= htmlspecialchars($settings['subscriber_count'] ?? '1L+') ?></span>
                  <span class="label">Subscribers</span>
                </div>
                <div class="tb-mini-stat">
                  <span class="num"><?= htmlspecialchars($settings['video_count'] ?? '500+') ?></span>
                  <span class="label">Videos</span>
                </div>
                <div class="tb-mini-stat">
                  <span class="num"><?= htmlspecialchars($settings['views_count'] ?? '1 Cr+') ?></span>
                  <span class="label">Views</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Scroll Indicator -->
  <div class="tb-scroll-indicator">
    <a href="#stats"><i class="fa-solid fa-chevron-down"></i></a>
  </div>
</section>

<!-- ==================== STATS SECTION ==================== -->
<section class="tb-stats py-5" id="stats">
  <div class="container">
    <div class="row g-4 text-center">
      <div class="col-6 col-md-3">
        <div class="tb-stat-card animate__animated" data-animate="fadeInUp">
          <div class="tb-stat-icon"><i class="fa-solid fa-users"></i></div>
          <div class="tb-stat-number" data-count="<?= str_replace(['+', ',', ' '], '', $settings['subscriber_count'] ?? '100000') ?>">0</div>
          <div class="tb-stat-label">Subscribers / Sadasya</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="tb-stat-card animate__animated" data-animate="fadeInUp" data-delay="100">
          <div class="tb-stat-icon"><i class="fa-solid fa-video"></i></div>
          <div class="tb-stat-number" data-count="<?= str_replace(['+', ',', ' '], '', $settings['video_count'] ?? '500') ?>">0</div>
          <div class="tb-stat-label">Videos / Vedio</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="tb-stat-card animate__animated" data-animate="fadeInUp" data-delay="200">
          <div class="tb-stat-icon"><i class="fa-solid fa-eye"></i></div>
          <div class="tb-stat-number" data-count="10000000">0</div>
          <div class="tb-stat-label">Total Views / Drishtikon</div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="tb-stat-card animate__animated" data-animate="fadeInUp" data-delay="300">
          <div class="tb-stat-icon"><i class="fa-solid fa-star"></i></div>
          <div class="tb-stat-number" data-count="4">0</div>
          <div class="tb-stat-label">Years / Saal</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ==================== SERVICES SECTION ==================== -->
<section class="tb-section tb-services-home py-5" id="services">
  <div class="container">
    <div class="tb-section-header text-center mb-4">
      <span class="tb-section-badge"><i class="fa-solid fa-layer-group me-2"></i>Hamare Content & Topics</span>
      <h2 class="tb-section-title"><i class="fa-solid fa-laptop-code text-primary me-2"></i>Kya Seekhoge Aaj? <span class="tb-gradient-text">📚</span></h2>
      <p class="tb-section-subtitle"><i class="fa-solid fa-circle-check text-success me-1"></i> Technology ke sabhi topics — simple Hindi mein, bilkul free!</p>

      <!-- Content Highlight Feature Pills with Icons -->
      <div class="tb-feature-pills">
        <span class="tb-feature-pill"><i class="fa-solid fa-bolt text-warning"></i> 100% Practical</span>
        <span class="tb-feature-pill"><i class="fa-solid fa-language text-info"></i> Hindi + English</span>
        <span class="tb-feature-pill"><i class="fa-solid fa-circle-play text-danger"></i> HD Video Tutorials</span>
        <span class="tb-feature-pill"><i class="fa-solid fa-certificate text-success"></i> Beginner to Pro</span>
      </div>
    </div>

    <div class="row g-4 mt-2">
      <?php foreach ($activeServices as $service): ?>
        <div class="col-lg-4 col-md-6">
          <a href="services.php?cat=<?= $service['id'] ?>" class="text-decoration-none">
            <div class="tb-service-card" style="--service-color: <?= htmlspecialchars($service['color']) ?>">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="tb-card-tag"><i class="fa-solid fa-play-circle me-1"></i> Content Series</span>
                <span class="tb-card-badge"><i class="fa-solid fa-gift me-1"></i> Free</span>
              </div>

              <div class="tb-service-icon">
                <?= renderIcon($service['icon']) ?>
              </div>
              <h3 class="tb-service-title"><?= htmlspecialchars($service['title']) ?></h3>
              <?php if (!empty($service['title_hi'])): ?>
                <div class="tb-service-title-hi"><?= htmlspecialchars($service['title_hi']) ?></div>
              <?php endif; ?>
              <p class="tb-service-desc"><?= htmlspecialchars($service['description'] ?? '') ?></p>

              <!-- Features checklist with icons -->
              <ul class="tb-service-features list-unstyled">
                <li><i class="fa-solid fa-check text-success me-2"></i> Step-by-Step Practical Guides</li>
                <li><i class="fa-solid fa-video me-2" style="color:var(--service-color)"></i> Real-world Projects & Demos</li>
              </ul>

              <div class="tb-service-link">
                <span>Explore Videos</span> <i class="fa-solid fa-arrow-right ms-1"></i>
              </div>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-5">
      <a href="services.php" class="btn tb-btn-primary btn-lg">
        <i class="fa-solid fa-film me-2"></i> Saare Videos & Topics Dekho <i class="fa-solid fa-arrow-right ms-2"></i>
      </a>
    </div>
  </div>
</section>

<!-- ==================== FEATURED VIDEOS SECTION ==================== -->
<?php if (!empty($featuredVideos)): ?>
<section class="tb-section tb-featured-videos py-5 bg-light" id="featured">
  <div class="container">
    <div class="tb-section-header text-center mb-5">
      <span class="tb-section-badge"><i class="fa-solid fa-fire me-1"></i> Trending</span>
      <h2 class="tb-section-title">Featured <span class="tb-gradient-text">Videos</span> 🎬</h2>
      <p class="tb-section-subtitle">Hamare sabse popular videos — ek baar zaroor dekho!</p>
    </div>
    <div class="row g-4">
      <?php foreach ($featuredVideos as $video): ?>
        <div class="col-lg-4 col-md-6">
          <div class="tb-video-card">
            <div class="tb-video-thumb" data-yt-id="<?= htmlspecialchars($video['youtube_id']) ?>">
              <img src="<?= getYoutubeThumbnail($video['youtube_id']) ?>"
                   alt="<?= htmlspecialchars($video['title']) ?>"
                   loading="lazy">
              <div class="tb-video-play-btn">
                <i class="fa-solid fa-play"></i>
              </div>
              <?php if (!empty($video['duration'])): ?>
                <span class="tb-video-duration"><?= htmlspecialchars($video['duration']) ?></span>
              <?php endif; ?>
              <?php if (!empty($video['service_title'])): ?>
                <span class="tb-video-category" style="background:<?= htmlspecialchars($video['service_color'] ?? '#ff6600') ?>">
                  <?= htmlspecialchars($video['service_title']) ?>
                </span>
              <?php endif; ?>
            </div>
            <div class="tb-video-info">
              <h4 class="tb-video-title"><?= htmlspecialchars($video['title']) ?></h4>
              <?php if (!empty($video['description'])): ?>
                <p class="tb-video-desc"><?= htmlspecialchars(mb_substr($video['description'], 0, 90)) ?>...</p>
              <?php endif; ?>
              <div class="tb-video-meta">
                <span><i class="fa-solid fa-clock me-1"></i><?= timeAgo($video['created_at']) ?></span>
                <a href="https://youtube.com/watch?v=<?= htmlspecialchars($video['youtube_id']) ?>"
                   target="_blank" class="tb-watch-yt">
                  <i class="fa-brands fa-youtube me-1"></i> Watch on YouTube
                </a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-5">
      <a href="services.php" class="btn tb-btn-secondary btn-lg">
        Aur Videos Dekho <i class="fa-solid fa-arrow-right ms-2"></i>
      </a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ==================== CTA SECTION ==================== -->
<section class="tb-cta-section py-5">
  <div class="container">
    <div class="tb-cta-box text-center">
      <div class="tb-cta-icon mb-3">
        <i class="fa-brands fa-youtube"></i>
      </div>
      <h2>YouTube pe Subscribe Karo! 🚀</h2>
      <p class="mt-2 mb-4">Naye videos ki notification turant pao. Free mein tech seekho!</p>
      <div class="d-flex flex-wrap gap-3 justify-content-center">
        <a href="<?= htmlspecialchars($settings['youtube_channel'] ?? '#') ?>"
           target="_blank" class="btn tb-btn-youtube btn-lg">
          <i class="fa-brands fa-youtube me-2"></i> Subscribe Now — Free!
        </a>
        <a href="contact.php" class="btn tb-btn-outline-light btn-lg">
          <i class="fa-solid fa-envelope me-2"></i> Hum se Samparkit Karo
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ==================== VIDEO MODAL ==================== -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-label="Video Player">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content bg-black border-0">
      <div class="modal-header border-0 pb-0">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-0 pb-3 px-3">
        <div class="ratio ratio-16x9">
          <iframe id="videoIframe" src="" allowfullscreen allow="autoplay; encrypted-media" frameborder="0"></iframe>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>
