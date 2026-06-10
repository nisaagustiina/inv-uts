<?php
require_once 'config/db.php';
include 'includes/header.php';

$stmt = $pdo->query("SELECT goods.*, categories.name as category_name 
                     FROM goods 
                     JOIN categories ON goods.category_id = categories.id 
                     ORDER BY categories.name, goods.name");
$goods = $stmt->fetchAll();

$total_goods = count($goods);
$total_value = array_sum(array_column($goods, 'price'));

$cat_counts = [];
$cat_values = [];
foreach ($goods as $g) {
    $cat = $g['category_name'];
    $cat_counts[$cat] = ($cat_counts[$cat] ?? 0) + 1;
    $cat_values[$cat] = ($cat_values[$cat] ?? 0) + $g['price'];
}
?>

<div class="page-header">
    <div>
        <h1 class="page-header-title">Inventory Report</h1>
        <div class="page-header-subtitle">Overview of all goods and categories</div>
    </div>
</div>

<!-- Summary Stats -->
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="stat-card" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
            <div class="stat-card-icon"><i class="bi bi-box"></i></div>
            <div class="stat-card-value"><?php echo $total_goods; ?></div>
            <div class="stat-card-label">Total Goods</div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card" style="background: linear-gradient(135deg, #10b981, #059669);">
            <div class="stat-card-icon"><i class="bi bi-currency-dollar"></i></div>
            <div class="stat-card-value" style="font-size:18px;">Rp <?php echo number_format($total_value, 2, ',', '.'); ?></div>
            <div class="stat-card-label">Total Inventory Value</div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
            <div class="stat-card-icon"><i class="bi bi-tags"></i></div>
            <div class="stat-card-value"><?php echo count($cat_counts); ?></div>
            <div class="stat-card-label">Categories Used</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Category breakdown -->
    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0 fw-semibold" style="font-size:14px;">Goods by Category</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size:13.5px;">
                    <thead>
                        <tr>
                            <th style="padding:10px 16px;background:#f8fafc;color:#475569;font-size:11px;font-weight:600;letter-spacing:.6px;text-transform:uppercase;">Category</th>
                            <th style="padding:10px 16px;background:#f8fafc;color:#475569;font-size:11px;font-weight:600;letter-spacing:.6px;text-transform:uppercase;">Count</th>
                            <th style="padding:10px 16px;background:#f8fafc;color:#475569;font-size:11px;font-weight:600;letter-spacing:.6px;text-transform:uppercase;">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cat_counts as $cat => $cnt): ?>
                            <tr>
                                <td style="padding:10px 16px;"><?php echo htmlspecialchars($cat); ?></td>
                                <td style="padding:10px 16px;">
                                    <span style="background:#dbeafe;color:#1d4ed8;padding:2px 8px;border-radius:20px;font-size:11px;font-weight:600;"><?php echo $cnt; ?></span>
                                </td>
                                <td style="padding:10px 16px;font-weight:600;">Rp <?php echo number_format($cat_values[$cat], 2, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($cat_counts)): ?>
                            <tr>
                                <td colspan="3" class="text-center py-3 text-muted">No data available.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Detailed goods list -->
    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0 fw-semibold" style="font-size:14px;">All Goods</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size:13.5px;">
                    <thead>
                        <tr>
                            <th style="padding:10px 16px;background:#f8fafc;color:#475569;font-size:11px;font-weight:600;letter-spacing:.6px;text-transform:uppercase;">Name</th>
                            <th style="padding:10px 16px;background:#f8fafc;color:#475569;font-size:11px;font-weight:600;letter-spacing:.6px;text-transform:uppercase;">Price</th>
                            <th style="padding:10px 16px;background:#f8fafc;color:#475569;font-size:11px;font-weight:600;letter-spacing:.6px;text-transform:uppercase;">Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($goods as $good): ?>
                            <tr>
                                <td style="padding:10px 16px;font-weight:500;"><?php echo htmlspecialchars($good['name']); ?></td>
                                <td style="padding:10px 16px;font-weight:600;color:#0f172a;">Rp <?php echo number_format($good['price'], 2, ',', '.'); ?></td>
                                <td style="padding:10px 16px;">
                                    <span style="background:#f1f5f9;color:#475569;padding:2px 8px;border-radius:20px;font-size:11px;font-weight:500;">
                                        <?php echo htmlspecialchars($good['category_name']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($goods)): ?>
                            <tr>
                                <td colspan="3" class="text-center py-3 text-muted">No goods found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>