<?php
require_once 'config/db.php';
include 'includes/header.php';

// pagination
$per_page   = 10;
$page       = max(1, (int)($_GET['page'] ?? 1));
$offset     = ($page - 1) * $per_page;

// total count
$total_items = $pdo->query("SELECT COUNT(*) FROM goods")->fetchColumn();
$total_pages = max(1, (int)ceil($total_items / $per_page));
$page        = min($page, $total_pages);
$offset      = ($page - 1) * $per_page;

// fetch data
$stmt = $pdo->prepare("
    SELECT goods.*, categories.name AS category_name
    FROM goods
    JOIN categories ON goods.category_id = categories.id
    ORDER BY goods.id DESC
    LIMIT :limit OFFSET :offset
");
$stmt->bindValue(':limit',  $per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset,   PDO::PARAM_INT);
$stmt->execute();
$goods = $stmt->fetchAll();

//helper
function page_url(int $p): string
{
    $params = $_GET;
    $params['page'] = $p;
    return '?' . http_build_query($params);
}
?>

<div class="page-header">
    <div>
        <h1 class="page-header-title">Goods</h1>
        <div class="page-header-subtitle"><?php echo $total_items; ?> items in inventory</div>
    </div>
    <?php if ($_SESSION['role'] === 'admin'): ?>
        <a href="add_good.php" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Add New Good
        </a>
    <?php endif; ?>
</div>

<div class="table-card">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Unit</th>
                <th>Stock</th>
                <th>Category</th>
                <?php if ($_SESSION['role'] === 'admin'): ?><th>Actions</th><?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($goods)): ?>
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">No goods found. Add your first item.</td>
                </tr>
            <?php else: ?>
                <?php
                $no = $offset + 1;
                foreach ($goods as $good): ?>
                    <tr>
                        <td class="text-muted"><?php echo $no++; ?></td>
                        <td style="font-weight:500;"><?php echo htmlspecialchars($good['name']); ?></td>
                        <td class="text-muted" style="max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?php echo htmlspecialchars($good['description']); ?></td>
                        <td style="font-weight:600;color:#0f172a;">Rp <?php echo number_format($good['price'], 2, ',', '.'); ?></td>
                        <td style="font-weight:500;"><?php echo $good['unit'] ?></td>
                        <td style="font-weight:500;"><?php echo $good['stock'] ?></td>
                        <td>
                            <span style="background:#f1f5f9;color:#475569;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:500;">
                                <?php echo htmlspecialchars($good['category_name']); ?>
                            </span>
                        </td>
                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <td>
                                <div class="btn-action-group">
                                    <a href="edit_good.php?id=<?php echo $good['id']; ?>" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil me-1"></i>Edit
                                    </a>
                                    <a href="delete_good.php?id=<?php echo $good['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?')">
                                        <i class="bi bi-trash me-1"></i>Delete
                                    </a>
                                </div>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination footer -->
    <?php if ($total_pages > 1): ?>
        <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-top:1px solid #e2e8f0;">
            <div style="font-size:13px;color:#64748b;">
                Showing <strong><?php echo $offset + 1; ?>-<?php echo min($offset + $per_page, $total_items); ?></strong>
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