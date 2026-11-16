<?php
// ============================================================
// TechnicalBabaOffice - Services / Videos Page
// ============================================================
$pageTitle = 'Videos & Services - Technical Baba';
require_once 'includes/header.php';

// Pagination
$perPage = 9;
$page    = max(1, (int)($_GET['p'] ?? 1));
$catId   = max(0, (int)($_GET['cat'] ?? 0));
$offset  = ($page - 1) * $perPage;

// Fetch data
$services = getActiveServices();
$videos   = getAllVideos($catId, $perPage, $offset);
$total    = countVideos($catId);
$pages    = max(1, (int)ceil($total / $perPage));

$activeService = $catId > 0 ? getServiceById($catId) : null;

// Build pagination URL
function pageUrl(int $p, int $cat = 0): string {
    $url = url('services') . '?p=' . $p;
    if ($cat > 0) $url .= '&cat=' . $cat;
    return $url;
}
?>

<!-- ==================== PAGE HERO ==================== -->
<section class="tb-page-hero">
  <div class="container">
    <div class="tb-breadcrumb">
      <a href="<?= url() ?>">Home</a>
      <i class="fa-solid fa-chevron-right"></i>
      <span>Videos & Services</span>
      <?php if ($activeService): ?>
        <i class="fa-solid fa-chevron-right"></i>
        <span><?= htmlspecialchars($activeService['title']) ?></span>
      <?php endif; ?>
    </div>
    <h1>
      <?php if ($activeService): ?>
        <span style="color:<?= htmlspecialchars($activeService['color']) ?>" class="me-2"><?= renderIcon($activeService['icon']) ?></span>
        <?= htmlspecialchars($activeService['title']) ?>
      <?php else: ?>
        <i class="fa-solid fa-film text-warning me-2"></i> Videos & Content Library
      <?php endif; ?>
    </h1>
    <p class="mt-2">
      <?php if ($activeService): ?>
        <?= htmlspecialchars($activeService['description'] ?? '') ?>
      <?php else: ?>
        Tamam technology topics — simple Hindi mein. Free mein seekho, aage badho!
      <?php endif; ?>
    </p>
  </div>
</section>

<!-- ==================== FILTER + CONTENT ==================== -->
<section class="py-5">
  <div class="container">

    <!-- Filter Tabs -->
    <div class="mb-4">
      <div class="tb-filter-tabs">
        <a href="<?= url('services') ?>" class="tb-filter-tab <?= $catId === 0 ? 'active' : '' ?>">
          <i class="fa-solid fa-border-all me-1"></i> Sab Kuch
        </a>
        <?php foreach ($services as $svc): ?>
          <a href="<?= url('services') ?>?cat=<?= $svc['id'] ?>"
             class="tb-filter-tab <?= $catId === (int)$svc['id'] ? 'active' : '' ?>">
            <span style="color:<?= htmlspecialchars($svc['color']) ?>" class="me-1"><?= renderIcon($svc['icon']) ?></span>
            <?= htmlspecialchars($svc['title']) ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Results Info -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
      <p class="text-muted mb-0">
        Dikha rahe hain <strong><?= count($videos) ?></strong> video<?= count($videos) !== 1 ? 's' : '' ?>
        <?php if ($total > $perPage): ?> (kul <?= $total ?> mein se) <?php endif; ?>
        <?php if ($activeService): ?> — <strong><?= htmlspecialchars($activeService['title']) ?></strong> <?php endif; ?>
      </p>
      <?php if ($total > 0): ?>
        <small class="text-muted">Page <?= $page ?> of <?= $pages ?></small>
      <?php endif; ?>
    </div>

    <!-- Videos Grid -->
    <?php if (empty($videos)): ?>
      <div class="text-center py-5">
        <div style="font-size:4rem;">😕</div>
        <h3 class="mt-3">Koi video nahi mila</h3>
        <p class="text-muted">Is category mein abhi koi video nahi hai.</p>
        <a href="services.php" class="btn tb-btn-primary mt-3">Saare Videos Dekho</a>
      </div>
    <?php else: ?>
      <div class="row g-4" id="videosGrid">
        <?php foreach ($videos as $video): ?>
          <div class="col-lg-4 col-md-6 animate-on-scroll">
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
                  <span class="tb-video-category"
                        style="background:<?= htmlspecialchars($video['service_color'] ?? '#ff6600') ?>">
                    <?= htmlspecialchars($video['service_title']) ?>
                  </span>
                <?php endif; ?>
                <?php if ($video['is_featured']): ?>
                  <span style="position:absolute;top:8px;right:8px;background:var(--tb-primary);color:white;padding:2px 8px;border-radius:50px;font-size:0.65rem;font-weight:700;">
                    ⭐ Featured
                  </span>
                <?php endif; ?>
              </div>
              <div class="tb-video-info">
                <h4 class="tb-video-title"><?= htmlspecialchars($video['title']) ?></h4>
                <?php if (!empty($video['description'])): ?>
                  <p class="tb-video-desc"><?= htmlspecialchars(mb_substr($video['description'], 0, 100)) ?>...</p>
                <?php endif; ?>
                <div class="tb-video-meta">
                  <span><i class="fa-solid fa-clock me-1"></i><?= timeAgo($video['created_at']) ?></span>
                  <a href="https://youtube.com/watch?v=<?= htmlspecialchars($video['youtube_id']) ?>"
                     target="_blank" class="tb-watch-yt">
                    <i class="fa-brands fa-youtube me-1"></i> YouTube
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Pagination -->
      <?php if ($pages > 1): ?>
        <div class="mt-5 d-flex justify-content-center">
          <div class="tb-pagination">
            <?php if ($page > 1): ?>
              <a href="<?= pageUrl($page - 1, $catId) ?>"><i class="fa-solid fa-chevron-left"></i></a>
            <?php endif; ?>
            <?php for ($i = max(1, $page - 2); $i <= min($pages, $page + 2); $i++): ?>
              <?php if ($i === $page): ?>
                <span class="active"><?= $i ?></span>
              <?php else: ?>
                <a href="<?= pageUrl($i, $catId) ?>"><?= $i ?></a>
              <?php endif; ?>
            <?php endfor; ?>
            <?php if ($page < $pages): ?>
              <a href="<?= pageUrl($page + 1, $catId) ?>"><i class="fa-solid fa-chevron-right"></i></a>
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>
    <?php endif; ?>

  </div>
</section>

<!-- ==================== SERVICES OVERVIEW ==================== -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="tb-section-header text-center mb-5">
      <span class="tb-section-badge">Hamare Categories</span>
      <h2 class="tb-section-title">Kya Sikha Sakte Hain? <span class="tb-gradient-text">🎓</span></h2>
    </div>
    <div class="row g-3">
      <?php foreach ($services as $svc): ?>
        <div class="col-lg-4 col-md-6">
          <a href="<?= url('services') ?>?cat=<?= $svc['id'] ?>" class="text-decoration-none">
            <div class="d-flex align-items-center gap-3 p-3 bg-white rounded-3 border h-100"
                 style="transition:all 0.3s;border-color:#e8edf5!important"
                 onmouseover="this.style.borderColor='<?= htmlspecialchars($svc['color']) ?>'"
                 onmouseout="this.style.borderColor='#e8edf5'">
              <div style="width:48px;height:48px;border-radius:12px;background:<?= htmlspecialchars($svc['color']) ?>20;
                          display:flex;align-items:center;justify-content:center;flex-shrink:0;
                          font-size:1.3rem;color:<?= htmlspecialchars($svc['color']) ?>">
                <?= renderIcon($svc['icon']) ?>
              </div>
              <div>
                <div style="font-weight:700;color:#0d1b2a;font-size:0.95rem"><?= htmlspecialchars($svc['title']) ?></div>
                <?php if (!empty($svc['title_hi'])): ?>
                  <div style="font-size:0.75rem;color:#8b9ab0"><?= htmlspecialchars($svc['title_hi']) ?></div>
                <?php endif; ?>
              </div>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Video Modal -->
<div class="modal fade" id="videoModal" tabindex="-1">
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
