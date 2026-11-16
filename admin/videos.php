<?php
// ============================================================
// TechnicalBabaOffice - Admin: Manage Videos (CRUD)
// ============================================================
$pageTitle = 'Videos';
require_once '../layout/header.php';

$db = getDB();

// --- Handle DELETE ---
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $db->prepare("DELETE FROM videos WHERE id = ?")->execute([(int)$_GET['delete']]);
    flashMessage('success', 'Video deleted successfully.');
    redirect(ADMIN_URL . '/videos.php');
}

// --- Handle SAVE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id  = (int)($_POST['id'] ?? 0);
    $ytId = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['youtube_id'] ?? '');
    $data = [
        (int)($_POST['service_id']  ?? 0) ?: null,
        sanitize($_POST['title']       ?? ''),
        sanitize($_POST['description'] ?? ''),
        $ytId,
        sanitize($_POST['duration']    ?? ''),
        (int)($_POST['is_featured'] ?? 0),
        (int)($_POST['is_active']   ?? 1),
        (int)($_POST['sort_order']  ?? 0),
    ];

    if (empty($data[3]) || strlen($data[3]) < 5) {
        flashMessage('error', 'Valid YouTube Video ID required.');
        redirect(ADMIN_URL . '/videos.php' . ($id ? "?edit=$id" : ''));
    }

    if ($id > 0) {
        $data[] = $id;
        $db->prepare("UPDATE videos SET service_id=?,title=?,description=?,youtube_id=?,duration=?,is_featured=?,is_active=?,sort_order=? WHERE id=?")->execute($data);
        flashMessage('success', 'Video updated.');
    } else {
        $db->prepare("INSERT INTO videos (service_id,title,description,youtube_id,duration,is_featured,is_active,sort_order) VALUES (?,?,?,?,?,?,?,?)")->execute($data);
        flashMessage('success', 'Video added.');
    }
    redirect(ADMIN_URL . '/videos.php');
}

// --- Fetch edit record ---
$editing = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM videos WHERE id = ?");
    $stmt->execute([(int)$_GET['edit']]);
    $editing = $stmt->fetch();
}

// --- Pagination ---
$perPage = 15;
$page    = max(1, (int)($_GET['p'] ?? 1));
$offset  = ($page - 1) * $perPage;
$total   = (int)$db->query("SELECT COUNT(*) FROM videos")->fetchColumn();
$pages   = max(1, (int)ceil($total / $perPage));

$videos   = $db->query("SELECT v.*, s.title AS service_title FROM videos v
                         LEFT JOIN services s ON s.id = v.service_id
                         ORDER BY v.sort_order ASC, v.id DESC
                         LIMIT $perPage OFFSET $offset")->fetchAll();
$services = $db->query("SELECT id, title FROM services WHERE is_active = 1 ORDER BY sort_order")->fetchAll();
?>

<div class="row">

  <!-- Add/Edit Form -->
  <div class="col-lg-4 <?= $editing ? '' : 'collapse' ?>" id="videoFormCol">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-<?= $editing ? 'edit' : 'plus-circle' ?> mr-2"></i>
          <?= $editing ? 'Edit Video' : 'Add Video' ?>
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" onclick="toggleVideoForm()"><i class="fas fa-times"></i></button>
        </div>
      </div>
      <form method="POST" action="videos.php">
        <div class="card-body">
          <?php if ($editing): ?>
            <input type="hidden" name="id" value="<?= $editing['id'] ?>">
          <?php endif; ?>

          <div class="form-group">
            <label>YouTube Video ID *</label>
            <input type="text" id="youtube_id" name="youtube_id" class="form-control" required maxlength="20"
                   value="<?= htmlspecialchars($editing['youtube_id'] ?? '') ?>"
                   placeholder="e.g. dQw4w9WgXcQ (11 chars)">
            <small class="text-muted">YouTube URL se "v=" ke baad ka 11-char code daalo</small>
            <img id="yt-preview" src="" class="mt-2 w-100 rounded" style="display:<?= $editing ? 'block' : 'none' ?>;max-height:120px;object-fit:cover">
          </div>
          <div class="form-group">
            <label>Title *</label>
            <input type="text" name="title" class="form-control" required maxlength="300"
                   value="<?= htmlspecialchars($editing['title'] ?? '') ?>">
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($editing['description'] ?? '') ?></textarea>
          </div>
          <div class="form-row">
            <div class="form-group col-8">
              <label>Category / Service</label>
              <select name="service_id" class="form-control">
                <option value="">-- None --</option>
                <?php foreach ($services as $svc): ?>
                  <option value="<?= $svc['id'] ?>"
                    <?= (int)($editing['service_id'] ?? 0) === (int)$svc['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($svc['title']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-4">
              <label>Duration</label>
              <input type="text" name="duration" class="form-control"
                     value="<?= htmlspecialchars($editing['duration'] ?? '') ?>" placeholder="12:34">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-4">
              <label>Sort</label>
              <input type="number" name="sort_order" class="form-control" min="0"
                     value="<?= (int)($editing['sort_order'] ?? 0) ?>">
            </div>
            <div class="form-group col-4">
              <label>Featured</label>
              <select name="is_featured" class="form-control">
                <option value="0" <?= !($editing['is_featured'] ?? 0) ? 'selected' : '' ?>>No</option>
                <option value="1" <?=  ($editing['is_featured'] ?? 0) ? 'selected' : '' ?>>⭐ Yes</option>
              </select>
            </div>
            <div class="form-group col-4">
              <label>Status</label>
              <select name="is_active" class="form-control">
                <option value="1" <?= ($editing['is_active'] ?? 1) == 1 ? 'selected' : '' ?>>Active</option>
                <option value="0" <?= ($editing['is_active'] ?? 1) == 0 ? 'selected' : '' ?>>Hidden</option>
              </select>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary btn-block">
            <i class="fas fa-save mr-1"></i> <?= $editing ? 'Update Video' : 'Add Video' ?>
          </button>
          <?php if ($editing): ?>
            <a href="videos.php" class="btn btn-default btn-block mt-1">Cancel</a>
          <?php endif; ?>
        </div>
      </form>
    </div>
  </div>

  <!-- Table -->
  <div class="col-lg-<?= $editing ? '8' : '12' ?>">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-video mr-2"></i>All Videos (<?= $total ?>)</h3>
        <div class="card-tools">
          <button class="btn btn-primary btn-sm" onclick="toggleVideoForm()" id="addVideoBtn">
            <i class="fas fa-plus mr-1"></i> Add Video
          </button>
        </div>
      </div>
      <div class="card-body p-0">
        <?php if (empty($videos)): ?>
          <p class="text-center text-muted py-4">No videos yet.</p>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead>
                <tr><th>Thumb</th><th>Title</th><th>Category</th><th>Duration</th><th>Featured</th><th>Status</th><th>Actions</th></tr>
              </thead>
              <tbody>
                <?php foreach ($videos as $v): ?>
                  <tr>
                    <td><img src="<?= getYoutubeThumbnail($v['youtube_id']) ?>" class="admin-yt-thumb"></td>
                    <td>
                      <div style="max-width:200px">
                        <strong><?= htmlspecialchars(mb_substr($v['title'], 0, 50)) ?><?= mb_strlen($v['title']) > 50 ? '...' : '' ?></strong>
                      </div>
                    </td>
                    <td><small><?= htmlspecialchars($v['service_title'] ?? '-') ?></small></td>
                    <td><small><?= htmlspecialchars($v['duration'] ?? '-') ?></small></td>
                    <td><?= $v['is_featured'] ? '<span class="badge badge-featured">⭐ Yes</span>' : '<span class="badge badge-inactive">No</span>' ?></td>
                    <td><?= $v['is_active'] ? '<span class="badge badge-active">Active</span>' : '<span class="badge badge-inactive">Hidden</span>' ?></td>
                    <td class="text-nowrap">
                      <a href="https://youtube.com/watch?v=<?= htmlspecialchars($v['youtube_id']) ?>"
                         target="_blank" class="btn btn-xs btn-default mr-1" title="View on YouTube">
                        <i class="fab fa-youtube"></i>
                      </a>
                      <a href="videos.php?edit=<?= $v['id'] ?>" class="btn btn-xs btn-info mr-1">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="videos.php?delete=<?= $v['id'] ?>"
                         class="btn btn-xs btn-danger btn-delete"
                         data-item="video '<?= htmlspecialchars($v['title']) ?>'">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <!-- Pagination -->
          <?php if ($pages > 1): ?>
            <div class="card-footer clearfix">
              <ul class="pagination pagination-sm m-0 float-right">
                <?php for ($i = 1; $i <= $pages; $i++): ?>
                  <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                    <a class="page-link" href="videos.php?p=<?= $i ?>"><?= $i ?></a>
                  </li>
                <?php endfor; ?>
              </ul>
            </div>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>

</div>

<script>
function toggleVideoForm() {
  const col = document.getElementById('videoFormCol');
  col.classList.toggle('collapse');
}
<?php if ($editing): ?>
// Pre-load thumbnail for editing
document.addEventListener('DOMContentLoaded', function() {
  const yt = document.getElementById('youtube_id');
  const img = document.getElementById('yt-preview');
  if (yt && yt.value.length >= 11) {
    img.src = 'https://img.youtube.com/vi/' + yt.value + '/hqdefault.jpg';
    img.style.display = 'block';
  }
});
<?php endif; ?>
</script>

<?php require_once '../layout/footer.php'; ?>
