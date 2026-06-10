<?php
require_once 'config/db.php';
if ($_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}
include 'includes/header.php';

// pagination
$per_page   = 10;
$page       = max(1, (int)($_GET['page'] ?? 1));
$offset     = ($page - 1) * $per_page;

// total count
$total_items = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$total_pages = max(1, (int)ceil($total_items / $per_page));
$page        = min($page, $total_pages);
$offset      = ($page - 1) * $per_page;

// fetch data
$stmt = $pdo->prepare("
    SELECT * FROM users
    ORDER BY id DESC
    LIMIT :limit OFFSET :offset
");

$stmt->bindValue(':limit',  $per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset,   PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll();

function page_url(int $p): string
{
    $params = $_GET;
    $params['page'] = $p;
    return '?' . http_build_query($params);
}
?>

<div class="page-header">
    <div>
        <h1 class="page-header-title">User Management</h1>
        <div class="page-header-subtitle"><?php echo $total_items; ?> registered users</div>
    </div>
    <a href="add_user.php" class="btn btn-primary">
        <i class="bi bi-person-plus me-1"></i>Add New User
    </a>
</div>

<div class="table-card">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Userame</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created at</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = $offset + 1;
            foreach ($users as $user): ?>
                <tr>
                    <td class="text-muted"><?php echo $no++; ?></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:30px;height:30px;background:#e2e8f0;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:600;color:#475569;flex-shrink:0;">
                                <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                            </div>
                            <span style="font-weight:500;"><?php echo htmlspecialchars($user['name']); ?></span>
                        </div>
                    </td>
                    <td class="text-muted"><?php echo htmlspecialchars($user['username']); ?></td>
                    <td class="text-muted"><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <span class="role-badge <?php echo $user['role']; ?>">
                            <?php echo ucfirst($user['role']); ?>
                        </span>
                    </td>
                    <td class="text-muted" style="font-size:12px;"><?php echo date('d M Y', strtotime($user['created_at'])); ?></td>
                    <td>
                        <div class="btn-action-group">
                            <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </a>
                            <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this user?')">
                                    <i class="bi bi-trash me-1"></i>Delete
                                </a>
                            <?php else: ?>
                                <button class="btn btn-sm btn-secondary" disabled>You</button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination footer -->
    <?php if ($total_pages > 1): ?>
        <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-top:1px solid #e2e8f0;">
            <div style="font-size:13px;color:#64748b;">
                Showing <strong><?php echo $offset + 1; ?>–<?php echo min($offset + $per_page, $total_items); ?></strong>
                of <strong><?php echo $total_items; ?></strong> items
            </div>
            <nav>
                <ul class="pagination pagination-sm mb-0" style="gap:3px;">

                    <!-- Prev -->
                    <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="<?php echo page_url($page - 1); ?>" style="border-radius:6px;">
                            <i class="bi bi-chevron-left" style="font-size:11px;"></i>
                        </a>
                    </li>

                    <?php
                    $window = 2;
                    $start  = max(1, $page - $window);
                    $end    = min($total_pages, $page + $window);

                    // Left ellipsis
                    if ($start > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo page_url(1); ?>" style="border-radius:6px;">1</a>
                        </li>
                        <?php if ($start > 2): ?>
                            <li class="page-item disabled">
                                <span class="page-link" style="border-radius:6px;border:none;background:transparent;">…</span>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php for ($p = $start; $p <= $end; $p++): ?>
                        <li class="page-item <?php echo $p === $page ? 'active' : ''; ?>">
                            <a class="page-link" href="<?php echo page_url($p); ?>" style="border-radius:6px;"><?php echo $p; ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- Right ellipsis -->
                    <?php if ($end < $total_pages): ?>
                        <?php if ($end < $total_pages - 1): ?>
                            <li class="page-item disabled">
                                <span class="page-link" style="border-radius:6px;border:none;background:transparent;">…</span>
                            </li>
                        <?php endif; ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo page_url($total_pages); ?>" style="border-radius:6px;"><?php echo $total_pages; ?></a>
                        </li>
                    <?php endif; ?>

                    <!-- Next -->
                    <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                        <a class="page-link" href="<?php echo page_url($page + 1); ?>" style="border-radius:6px;">
                            <i class="bi bi-chevron-right" style="font-size:11px;"></i>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>