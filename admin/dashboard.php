<?php
// ============================================================
// TechnicalBabaOffice - Admin Dashboard
// ============================================================
$pageTitle = 'Dashboard';
require_once '../layout/header.php';

$db = getDB();

// Stats
$totalVideos    = (int)$db->query("SELECT COUNT(*) FROM videos")->fetchColumn();
$totalServices  = (int)$db->query("SELECT COUNT(*) FROM services")->fetchColumn();
$totalMessages  = (int)$db->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
$unreadMessages = (int)$db->query("SELECT COUNT(*) FROM contacts WHERE is_read = 0")->fetchColumn();
$featuredVideos = (int)$db->query("SELECT COUNT(*) FROM videos WHERE is_featured = 1")->fetchColumn();

// Recent contacts
$recentContacts = $db->query(
    "SELECT * FROM contacts ORDER BY created_at DESC LIMIT 5"
)->fetchAll();

// Recent videos
$recentVideos = $db->query(
    "SELECT v.*, s.title AS service_title FROM videos v
     LEFT JOIN services s ON s.id = v.service_id
     ORDER BY v.created_at DESC LIMIT 5"
)->fetchAll();
?>

<!-- ==================== STAT CARDS ==================== -->
<div class="row">

  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-tb-primary elevation-1"><i class="fas fa-video"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total Videos</span>
        <span class="info-box-number"><?= $totalVideos ?></span>
        <span class="progress-description">
          <small><strong><?= $featuredVideos ?></strong> featured</small>
        </span>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-tb-blue elevation-1"><i class="fas fa-list-alt"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Services / Categories</span>
        <span class="info-box-number"><?= $totalServices ?></span>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-tb-green elevation-1"><i class="fas fa-envelope"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total Messages</span>
        <span class="info-box-number"><?= $totalMessages ?></span>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-tb-red elevation-1"><i class="fas fa-bell"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Unread Messages</span>
        <span class="info-box-number"><?= $unreadMessages ?></span>
        <?php if ($unreadMessages > 0): ?>
          <span class="progress-description"><small class="text-danger">Needs attention!</small></span>
        <?php endif; ?>
      </div>
    </div>
  </div>

</div><!-- .row stats -->

<!-- ==================== QUICK ACTIONS ==================== -->
<div class="row mb-4">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-bolt mr-2 text-warning"></i>Quick Actions</h3>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-lg-3 col-md-6 col-6">
            <a href="add-video.php" class="tb-quick-action">
              <i class="fas fa-plus-circle" style="color:#ff6600"></i>
              <span>Add Video</span>
            </a>
          </div>
          <div class="col-lg-3 col-md-6 col-6">
            <a href="add-service.php" class="tb-quick-action">
              <i class="fas fa-folder-plus" style="color:#1a73e8"></i>
              <span>Add Service</span>
            </a>
          </div>
          <div class="col-lg-3 col-md-6 col-6">
            <a href="contacts.php" class="tb-quick-action">
              <i class="fas fa-envelope-open-text" style="color:#28a745"></i>
              <span>View Messages<?= $unreadMessages > 0 ? ' ('.$unreadMessages.')' : '' ?></span>
            </a>
          </div>
          <div class="col-lg-3 col-md-6 col-6">
            <a href="settings.php" class="tb-quick-action">
              <i class="fas fa-cog" style="color:#6f42c1"></i>
              <span>Site Settings</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ==================== RECENT DATA TABLES ==================== -->
<div class="row">

  <!-- Recent Messages -->
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-envelope mr-2" style="color:#28a745"></i>Recent Messages</h3>
        <div class="card-tools">
          <a href="contacts.php" class="btn btn-sm btn-default">View All</a>
        </div>
      </div>
      <div class="card-body p-0">
        <?php if (empty($recentContacts)): ?>
          <p class="text-center text-muted py-4">No messages yet.</p>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-hover table-sm mb-0">
              <thead>
                <tr>
                  <th>Name</th><th>Subject</th><th>Time</th><th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($recentContacts as $msg): ?>
                  <tr>
                    <td>
                      <strong><?= htmlspecialchars($msg['name']) ?></strong>
                      <br><small class="text-muted"><?= htmlspecialchars($msg['email']) ?></small>
                    </td>
                    <td><?= htmlspecialchars(mb_substr($msg['subject'] ?? 'No subject', 0, 30)) ?></td>
                    <td><small><?= timeAgo($msg['created_at']) ?></small></td>
                    <td>
                      <?php if (!$msg['is_read']): ?>
                        <span class="badge badge-unread">Unread</span>
                      <?php else: ?>
                        <span class="badge badge-active">Read</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Recent Videos -->
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-video mr-2" style="color:#ff6600"></i>Recent Videos</h3>
        <div class="card-tools">
          <a href="videos.php" class="btn btn-sm btn-default">View All</a>
        </div>
      </div>
      <div class="card-body p-0">
        <?php if (empty($recentVideos)): ?>
          <p class="text-center text-muted py-4">No videos yet.</p>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-hover table-sm mb-0">
              <thead>
                <tr><th>Thumb</th><th>Title</th><th>Category</th><th>Featured</th></tr>
              </thead>
              <tbody>
                <?php foreach ($recentVideos as $v): ?>
                  <tr>
                    <td>
                      <img src="<?= getYoutubeThumbnail($v['youtube_id']) ?>"
                           class="admin-yt-thumb" alt="">
                    </td>
                    <td>
                      <?= htmlspecialchars(mb_substr($v['title'], 0, 40)) ?>
                      <?php if (mb_strlen($v['title']) > 40): ?>...<?php endif; ?>
                    </td>
                    <td><small class="text-muted"><?= htmlspecialchars($v['service_title'] ?? '-') ?></small></td>
                    <td>
                      <?php if ($v['is_featured']): ?>
                        <span class="badge badge-featured">⭐ Yes</span>
                      <?php else: ?>
                        <span class="badge badge-inactive">No</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

</div><!-- .row -->

<?php require_once '../layout/footer.php'; ?>
