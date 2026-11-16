<?php
// ============================================================
// TechnicalBabaOffice - Admin: Manage Contact Messages
// ============================================================
$pageTitle = 'Messages / Contacts';
require_once '../layout/header.php';

$db = getDB();

// --- Handle DELETE ---
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $db->prepare("DELETE FROM contacts WHERE id = ?")->execute([(int)$_GET['delete']]);
    flashMessage('success', 'Message deleted.');
    redirect(ADMIN_URL . '/contacts.php');
}

// --- Handle Mark as Read/Replied ---
if (isset($_GET['mark_read']) && is_numeric($_GET['mark_read'])) {
    $db->prepare("UPDATE contacts SET is_read = 1 WHERE id = ?")->execute([(int)$_GET['mark_read']]);
    redirect(ADMIN_URL . '/contacts.php?view=' . $_GET['mark_read']);
}
if (isset($_GET['mark_replied']) && is_numeric($_GET['mark_replied'])) {
    $db->prepare("UPDATE contacts SET is_read = 1, is_replied = 1 WHERE id = ?")->execute([(int)$_GET['mark_replied']]);
    flashMessage('success', 'Marked as replied.');
    redirect(ADMIN_URL . '/contacts.php');
}

// --- View single message ---
$viewing = null;
if (isset($_GET['view']) && is_numeric($_GET['view'])) {
    $stmt = $db->prepare("SELECT * FROM contacts WHERE id = ?");
    $stmt->execute([(int)$_GET['view']]);
    $viewing = $stmt->fetch();
    if ($viewing && !$viewing['is_read']) {
        $db->prepare("UPDATE contacts SET is_read = 1 WHERE id = ?")->execute([$viewing['id']]);
        $viewing['is_read'] = 1;
    }
}

// --- Pagination ---
$perPage = 20;
$page    = max(1, (int)($_GET['p'] ?? 1));
$offset  = ($page - 1) * $perPage;
$filter  = $_GET['filter'] ?? 'all';

$whereClause = match($filter) {
    'unread'  => 'WHERE is_read = 0',
    'replied' => 'WHERE is_replied = 1',
    default   => '',
};

$total  = (int)$db->query("SELECT COUNT(*) FROM contacts $whereClause")->fetchColumn();
$pages  = max(1, (int)ceil($total / $perPage));
$msgs   = $db->query("SELECT * FROM contacts $whereClause ORDER BY created_at DESC LIMIT $perPage OFFSET $offset")->fetchAll();
$unread = (int)$db->query("SELECT COUNT(*) FROM contacts WHERE is_read = 0")->fetchColumn();
?>

<div class="row">

  <!-- Message List -->
  <div class="col-lg-<?= $viewing ? '5' : '12' ?>">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h3 class="card-title">
          <i class="fas fa-envelope mr-2"></i>
          Messages (<?= $total ?>)
          <?php if ($unread > 0): ?>
            <span class="badge badge-danger ml-1"><?= $unread ?> Unread</span>
          <?php endif; ?>
        </h3>
        <div class="d-flex gap-2 flex-wrap">
          <a href="contacts.php?filter=all"    class="btn btn-xs <?= $filter === 'all' ? 'btn-primary' : 'btn-default' ?>">All</a>
          <a href="contacts.php?filter=unread" class="btn btn-xs <?= $filter === 'unread' ? 'btn-primary' : 'btn-default' ?>">Unread (<?= $unread ?>)</a>
          <a href="contacts.php?filter=replied"class="btn btn-xs <?= $filter === 'replied'? 'btn-primary' : 'btn-default' ?>">Replied</a>
        </div>
      </div>
      <div class="card-body p-0">
        <?php if (empty($msgs)): ?>
          <p class="text-center text-muted py-5">
            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
            No messages found.
          </p>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead>
                <tr><th>Name / Email</th><th>Subject</th><th>Time</th><th>Status</th><th>Actions</th></tr>
              </thead>
              <tbody>
                <?php foreach ($msgs as $msg): ?>
                  <tr class="<?= !$msg['is_read'] ? 'table-warning' : '' ?>">
                    <td>
                      <strong><?= htmlspecialchars($msg['name']) ?></strong>
                      <br><small class="text-muted"><?= htmlspecialchars($msg['email']) ?></small>
                      <?php if (!empty($msg['phone'])): ?>
                        <br><small><i class="fas fa-phone text-muted mr-1"></i><?= htmlspecialchars($msg['phone']) ?></small>
                      <?php endif; ?>
                    </td>
                    <td>
                      <span title="<?= htmlspecialchars($msg['message']) ?>">
                        <?= htmlspecialchars(mb_substr($msg['subject'] ?? '(No subject)', 0, 35)) ?>
                      </span>
                    </td>
                    <td><small><?= timeAgo($msg['created_at']) ?></small></td>
                    <td>
                      <?php if (!$msg['is_read']): ?>
                        <span class="badge badge-unread">🔴 Unread</span>
                      <?php elseif ($msg['is_replied']): ?>
                        <span class="badge badge-active">✅ Replied</span>
                      <?php else: ?>
                        <span class="badge badge-inactive">Read</span>
                      <?php endif; ?>
                    </td>
                    <td class="text-nowrap">
                      <a href="contacts.php?view=<?= $msg['id'] ?>" class="btn btn-xs btn-info mr-1" title="View">
                        <i class="fas fa-eye"></i>
                      </a>
                      <a href="mailto:<?= htmlspecialchars($msg['email']) ?>?subject=Re: <?= urlencode($msg['subject'] ?? '') ?>"
                         class="btn btn-xs btn-success mr-1" title="Reply via Email">
                        <i class="fas fa-reply"></i>
                      </a>
                      <a href="contacts.php?delete=<?= $msg['id'] ?>"
                         class="btn btn-xs btn-danger btn-delete"
                         data-item="message from <?= htmlspecialchars($msg['name']) ?>">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <?php if ($pages > 1): ?>
            <div class="card-footer clearfix">
              <ul class="pagination pagination-sm m-0 float-right">
                <?php for ($i = 1; $i <= $pages; $i++): ?>
                  <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                    <a class="page-link" href="contacts.php?p=<?= $i ?>&filter=<?= urlencode($filter) ?>"><?= $i ?></a>
                  </li>
                <?php endfor; ?>
              </ul>
            </div>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Message Detail -->
  <?php if ($viewing): ?>
    <div class="col-lg-7">
      <div class="card card-info card-outline">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-envelope-open mr-2"></i>
            Message from <?= htmlspecialchars($viewing['name']) ?>
          </h3>
          <div class="card-tools">
            <a href="contacts.php" class="btn btn-tool"><i class="fas fa-times"></i></a>
          </div>
        </div>
        <div class="card-body">
          <dl class="row">
            <dt class="col-sm-3">From</dt>
            <dd class="col-sm-9"><strong><?= htmlspecialchars($viewing['name']) ?></strong></dd>

            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9">
              <a href="mailto:<?= htmlspecialchars($viewing['email']) ?>">
                <?= htmlspecialchars($viewing['email']) ?>
              </a>
            </dd>

            <?php if (!empty($viewing['phone'])): ?>
              <dt class="col-sm-3">Phone</dt>
              <dd class="col-sm-9">
                <a href="tel:<?= htmlspecialchars($viewing['phone']) ?>"><?= htmlspecialchars($viewing['phone']) ?></a>
              </dd>
            <?php endif; ?>

            <dt class="col-sm-3">Subject</dt>
            <dd class="col-sm-9"><?= htmlspecialchars($viewing['subject'] ?? '(No subject)') ?></dd>

            <dt class="col-sm-3">Received</dt>
            <dd class="col-sm-9"><?= date('d M Y, h:i A', strtotime($viewing['created_at'])) ?></dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
              <?php if ($viewing['is_replied']): ?>
                <span class="badge badge-active">✅ Replied</span>
              <?php else: ?>
                <span class="badge badge-inactive">Not replied yet</span>
              <?php endif; ?>
            </dd>
          </dl>

          <hr>
          <h6 class="mb-2">Message / Sandesh:</h6>
          <div class="p-3 rounded" style="background:#f8fafc;border:1px solid #e8edf5;white-space:pre-wrap;font-size:0.95rem">
            <?= htmlspecialchars($viewing['message']) ?>
          </div>
        </div>
        <div class="card-footer">
          <a href="mailto:<?= htmlspecialchars($viewing['email']) ?>?subject=Re: <?= urlencode($viewing['subject'] ?? 'Your message') ?>"
             class="btn btn-success mr-2">
            <i class="fas fa-reply mr-1"></i> Reply via Email
          </a>
          <?php if (!$viewing['is_replied']): ?>
            <a href="contacts.php?mark_replied=<?= $viewing['id'] ?>" class="btn btn-info mr-2">
              <i class="fas fa-check mr-1"></i> Mark as Replied
            </a>
          <?php endif; ?>
          <a href="contacts.php?delete=<?= $viewing['id'] ?>"
             class="btn btn-danger btn-delete"
             data-item="this message">
            <i class="fas fa-trash mr-1"></i> Delete
          </a>
        </div>
      </div>
    </div>
  <?php endif; ?>

</div>

<?php require_once '../layout/footer.php'; ?>
