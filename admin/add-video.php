<?php
// ============================================================
// TechnicalBabaOffice - Admin: Add Video
// ============================================================
$pageTitle = 'Add New Video';
require_once __DIR__ . '/layout/header.php';

$db = getDB();

if (isPost()) {
    $service_id  = (int)($_POST['service_id'] ?? 0) ?: null;
    $title       = sanitize($_POST['title'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    $ytId        = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['youtube_id'] ?? '');
    $duration    = sanitize($_POST['duration'] ?? '');
    $is_featured = (int)($_POST['is_featured'] ?? 0);
    $is_active   = (int)($_POST['is_active'] ?? 1);
    $sort_order  = (int)($_POST['sort_order'] ?? 0);

    if (empty($ytId) || strlen($ytId) < 5) {
        flashMessage('error', 'Valid YouTube Video ID is required.');
    } elseif (empty($title)) {
        flashMessage('error', 'Title is required.');
    } else {
        $stmt = $db->prepare("INSERT INTO videos (service_id, title, description, youtube_id, duration, is_featured, is_active, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$service_id, $title, $description, $ytId, $duration, $is_featured, $is_active, $sort_order]);
        flashMessage('success', 'Video added successfully!');
        redirect(admin_url('videos'));
    }
}

$services = $db->query("SELECT id, title FROM services WHERE is_active = 1 ORDER BY sort_order")->fetchAll();
?>

<div class="row">
  <div class="col-lg-8 mx-auto">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-video mr-2"></i>Add New Video</h3>
        <div class="card-tools">
          <a href="<?= admin_url('videos') ?>" class="btn btn-sm btn-default"><i class="fas fa-arrow-left mr-1"></i>Back to Videos</a>
        </div>
      </div>
      <form method="POST" action="<?= admin_url('add-video') ?>">
        <div class="card-body">
          <div class="form-group">
            <label>YouTube Video ID *</label>
            <input type="text" id="youtube_id" name="youtube_id" class="form-control" required maxlength="20"
                   placeholder="e.g. dQw4w9WgXcQ (11 characters from YouTube URL)">
            <small class="text-muted">Example: In https://youtube.com/watch?v=<b>dQw4w9WgXcQ</b>, the ID is <b>dQw4w9WgXcQ</b></small>
            <div class="mt-2 text-center">
              <img id="yt-preview" src="" class="rounded shadow-sm" style="display:none;max-height:160px;object-fit:cover">
            </div>
          </div>
          <div class="form-group">
            <label>Title *</label>
            <input type="text" name="title" class="form-control" required maxlength="300" placeholder="e.g. ChatGPT Complete Tutorial in Hindi">
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Description of the video content..."></textarea>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Service / Category</label>
              <select name="service_id" class="form-control">
                <option value="">-- Select Category --</option>
                <?php foreach ($services as $svc): ?>
                  <option value="<?= $svc['id'] ?>"><?= htmlspecialchars($svc['title']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label>Duration</label>
              <input type="text" name="duration" class="form-control" placeholder="e.g. 15:30">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label>Sort Order</label>
              <input type="number" name="sort_order" class="form-control" min="0" value="0">
            </div>
            <div class="form-group col-md-4">
              <label>Featured</label>
              <select name="is_featured" class="form-control">
                <option value="0">No</option>
                <option value="1">⭐ Yes</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label>Status</label>
              <select name="is_active" class="form-control">
                <option value="1">Active</option>
                <option value="0">Hidden</option>
              </select>
            </div>
          </div>
        </div>
        <div class="card-footer d-flex justify-content-between">
          <a href="<?= admin_url('videos') ?>" class="btn btn-default">Cancel</a>
          <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Publish Video</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const yt = document.getElementById('youtube_id');
  const preview = document.getElementById('yt-preview');
  if (yt && preview) {
    yt.addEventListener('input', function() {
      const val = this.value.trim();
      if (val.length === 11) {
        preview.src = 'https://img.youtube.com/vi/' + val + '/hqdefault.jpg';
        preview.style.display = 'inline-block';
      } else {
        preview.style.display = 'none';
      }
    });
  }
});
</script>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
