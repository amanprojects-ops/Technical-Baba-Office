<?php
// ============================================================
// TechnicalBabaOffice - Admin: Add Service
// ============================================================
$pageTitle = 'Add New Service';
require_once __DIR__ . '/layout/header.php';

$db = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title          = sanitize($_POST['title'] ?? '');
    $title_hi       = sanitize($_POST['title_hi'] ?? '');
    $description    = sanitize($_POST['description'] ?? '');
    $description_hi = sanitize($_POST['description_hi'] ?? '');
    $icon           = sanitize($_POST['icon'] ?? 'fa-video');
    $color          = sanitize($_POST['color'] ?? '#ff6600');
    $is_active      = (int)($_POST['is_active'] ?? 1);
    $sort_order     = (int)($_POST['sort_order'] ?? 0);

    if (empty($title)) {
        flashMessage('error', 'Title is required.');
    } else {
        $stmt = $db->prepare("INSERT INTO services (title, title_hi, description, description_hi, icon, color, is_active, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $title_hi, $description, $description_hi, $icon, $color, $is_active, $sort_order]);
        flashMessage('success', 'Service added successfully!');
        redirect(ADMIN_URL . '/services.php');
    }
}

$icons = ['video','youtube','star','book','code','mobile-alt','lightbulb','laptop','tools','brain','trophy','rocket','heart','fire'];
?>

<div class="row">
  <div class="col-lg-8 mx-auto">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-folder-plus mr-2"></i>Add New Service</h3>
        <div class="card-tools">
          <a href="services.php" class="btn btn-sm btn-default"><i class="fas fa-arrow-left mr-1"></i>Back to Services</a>
        </div>
      </div>
      <form method="POST" action="add-service.php">
        <div class="card-body">
          <div class="form-group">
            <label>Title (English) *</label>
            <input type="text" name="title" class="form-control" required maxlength="200" placeholder="e.g. YouTube Tutorials">
          </div>
          <div class="form-group">
            <label>Title (Hindi)</label>
            <input type="text" name="title_hi" class="form-control" maxlength="200" placeholder="e.g. यूट्यूब ट्यूटोरियल्स">
          </div>
          <div class="form-group">
            <label>Description (English)</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Brief description of the service"></textarea>
          </div>
          <div class="form-group">
            <label>Description (Hindi)</label>
            <textarea name="description_hi" class="form-control" rows="2" placeholder="संक्षिप्त विवरण"></textarea>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Icon</label>
              <select name="icon" class="form-control">
                <?php foreach ($icons as $ic): ?>
                  <option value="<?= $ic ?>">fa-<?= $ic ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label>Accent Color</label>
              <input type="color" name="color" class="form-control form-control-color" value="#ff6600">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Sort Order</label>
              <input type="number" name="sort_order" class="form-control" min="0" value="0">
            </div>
            <div class="form-group col-md-6">
              <label>Status</label>
              <select name="is_active" class="form-control">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
              </select>
            </div>
          </div>
        </div>
        <div class="card-footer d-flex justify-content-between">
          <a href="services.php" class="btn btn-default">Cancel</a>
          <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Save Service</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
