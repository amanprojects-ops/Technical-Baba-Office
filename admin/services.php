<?php
// ============================================================
// TechnicalBabaOffice - Admin: Manage Services (CRUD)
// ============================================================
$pageTitle = 'Services / Categories';
require_once '../layout/header.php';

$db = getDB();

// --- Handle DELETE ---
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $db->prepare("DELETE FROM services WHERE id = ?")->execute([(int)$_GET['delete']]);
    flashMessage('success', 'Service deleted successfully.');
    redirect(ADMIN_URL . '/services.php');
}

// --- Handle SAVE (Add/Edit) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id    = (int)($_POST['id'] ?? 0);
    $data  = [
        sanitize($_POST['title']          ?? ''),
        sanitize($_POST['title_hi']       ?? ''),
        sanitize($_POST['description']    ?? ''),
        sanitize($_POST['description_hi'] ?? ''),
        sanitize($_POST['icon']           ?? 'fa-video'),
        sanitize($_POST['color']          ?? '#ff6600'),
        (int)($_POST['is_active']  ?? 1),
        (int)($_POST['sort_order'] ?? 0),
    ];

    if ($id > 0) {
        $data[] = $id;
        $db->prepare("UPDATE services SET title=?,title_hi=?,description=?,description_hi=?,icon=?,color=?,is_active=?,sort_order=? WHERE id=?")->execute($data);
        flashMessage('success', 'Service updated successfully.');
    } else {
        $db->prepare("INSERT INTO services (title,title_hi,description,description_hi,icon,color,is_active,sort_order) VALUES (?,?,?,?,?,?,?,?)")->execute($data);
        flashMessage('success', 'Service added successfully.');
    }
    redirect(ADMIN_URL . '/services.php');
}

// --- Fetch edit record ---
$editing = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM services WHERE id = ?");
    $stmt->execute([(int)$_GET['edit']]);
    $editing = $stmt->fetch();
}

// --- Fetch all services ---
$services = $db->query("SELECT * FROM services ORDER BY sort_order ASC, id ASC")->fetchAll();

$icons = ['video','youtube','star','book','code','mobile-alt','lightbulb','laptop','tools','brain','trophy','rocket','heart','fire'];
?>

<div class="row">

  <!-- Form Card -->
  <div class="col-lg-4">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-<?= $editing ? 'edit' : 'plus-circle' ?> mr-2"></i>
          <?= $editing ? 'Edit Service' : 'Add New Service' ?>
        </h3>
      </div>
      <form method="POST" action="services.php">
        <div class="card-body">
          <?php if ($editing): ?>
            <input type="hidden" name="id" value="<?= $editing['id'] ?>">
          <?php endif; ?>

          <div class="form-group">
            <label>Title (English) *</label>
            <input type="text" name="title" class="form-control" required maxlength="200"
                   value="<?= htmlspecialchars($editing['title'] ?? '') ?>" placeholder="e.g. Coding Tutorials">
          </div>
          <div class="form-group">
            <label>Title (Hindi)</label>
            <input type="text" name="title_hi" class="form-control" maxlength="200"
                   value="<?= htmlspecialchars($editing['title_hi'] ?? '') ?>" placeholder="e.g. कोडिंग ट्यूटोरियल">
          </div>
          <div class="form-group">
            <label>Description (English)</label>
            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($editing['description'] ?? '') ?></textarea>
          </div>
          <div class="form-group">
            <label>Description (Hindi)</label>
            <textarea name="description_hi" class="form-control" rows="2"><?= htmlspecialchars($editing['description_hi'] ?? '') ?></textarea>
          </div>
          <div class="form-row">
            <div class="form-group col-8">
              <label>Icon (FontAwesome)</label>
              <select name="icon" class="form-control">
                <?php foreach ($icons as $ic): ?>
                  <option value="<?= $ic ?>" <?= ($editing['icon'] ?? '') === $ic ? 'selected' : '' ?>>
                    fa-<?= $ic ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-4">
              <label>Color</label>
              <input type="color" name="color" class="form-control form-control-color"
                     value="<?= htmlspecialchars($editing['color'] ?? '#ff6600') ?>">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <label>Sort Order</label>
              <input type="number" name="sort_order" class="form-control" min="0"
                     value="<?= (int)($editing['sort_order'] ?? 0) ?>">
            </div>
            <div class="form-group col-6">
              <label>Status</label>
              <select name="is_active" class="form-control">
                <option value="1" <?= ($editing['is_active'] ?? 1) == 1 ? 'selected' : '' ?>>Active</option>
                <option value="0" <?= ($editing['is_active'] ?? 1) == 0 ? 'selected' : '' ?>>Inactive</option>
              </select>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary btn-block">
            <i class="fas fa-save mr-1"></i> <?= $editing ? 'Update Service' : 'Add Service' ?>
          </button>
          <?php if ($editing): ?>
            <a href="services.php" class="btn btn-default btn-block mt-1">Cancel</a>
          <?php endif; ?>
        </div>
      </form>
    </div>
  </div>

  <!-- Table Card -->
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-list mr-2"></i>All Services (<?= count($services) ?>)</h3>
      </div>
      <div class="card-body p-0">
        <?php if (empty($services)): ?>
          <p class="text-center text-muted py-4">No services yet. Add one!</p>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead>
                <tr><th>#</th><th>Icon</th><th>Title</th><th>Sort</th><th>Status</th><th>Actions</th></tr>
              </thead>
              <tbody>
                <?php foreach ($services as $i => $svc): ?>
                  <tr>
                    <td><?= $i + 1 ?></td>
                    <td>
                      <span style="width:32px;height:32px;background:<?= htmlspecialchars($svc['color']) ?>20;
                                   border-radius:8px;display:inline-flex;align-items:center;justify-content:center;
                                   color:<?= htmlspecialchars($svc['color']) ?>">
                        <?= renderIcon($svc['icon']) ?>
                      </span>
                    </td>
                    <td>
                      <strong><?= htmlspecialchars($svc['title']) ?></strong>
                      <?php if (!empty($svc['title_hi'])): ?>
                        <br><small class="text-muted"><?= htmlspecialchars($svc['title_hi']) ?></small>
                      <?php endif; ?>
                    </td>
                    <td><?= (int)$svc['sort_order'] ?></td>
                    <td>
                      <?php if ($svc['is_active']): ?>
                        <span class="badge badge-active">Active</span>
                      <?php else: ?>
                        <span class="badge badge-inactive">Inactive</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <a href="services.php?edit=<?= $svc['id'] ?>" class="btn btn-xs btn-info mr-1">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="services.php?delete=<?= $svc['id'] ?>"
                         class="btn btn-xs btn-danger btn-delete"
                         data-item="<?= htmlspecialchars($svc['title']) ?>">
                        <i class="fas fa-trash"></i>
                      </a>
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

</div>

<?php require_once '../layout/footer.php'; ?>
