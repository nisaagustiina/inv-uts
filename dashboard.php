<?php
require_once 'config/db.php';
include 'includes/header.php';

// Quick stats
$total_goods      = $pdo->query("SELECT COUNT(*) FROM goods")->fetchColumn();
$total_categories = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
$total_value      = $pdo->query("SELECT COALESCE(SUM(price),0) FROM goods")->fetchColumn();
$total_users      = ($user_role === 'admin') ? $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn() : null;
?>

<div class="page-header">
    <div>
        <h1 class="page-header-title">Welcome back, <?php echo htmlspecialchars($user_name); ?>!</h1>
        <div class="page-header-subtitle">Here's what's happening in your inventory today.</div>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
            <div class="stat-card-icon"><i class="bi bi-box"></i></div>
            <div class="stat-card-value"><?php echo $total_goods; ?></div>
            <div class="stat-card-label">Total Goods</div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #10b981, #059669);">
            <div class="stat-card-icon"><i class="bi bi-tags"></i></div>
            <div class="stat-card-value"><?php echo $total_categories; ?></div>
            <div class="stat-card-label">Categories</div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
            <div class="stat-card-icon"><i class="bi bi-currency-dollar"></i></div>
            <div class="stat-card-value" style="font-size:18px;">Rp <?php echo number_format($total_value, 2, ',', '.'); ?></div>
            <div class="stat-card-label">Total Value</div>
        </div>
    </div>
    <?php if ($user_role === 'admin'): ?>
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                <div class="stat-card-icon"><i class="bi bi-people"></i></div>
                <div class="stat-card-value"><?php echo $total_users; ?></div>
                <div class="stat-card-label">System Users</div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Quick Actions -->
<div class="row g-3">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div style="width:40px;height:40px;background:#eff6ff;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-box text-primary" style="font-size:18px;"></i>
                    </div>
                    <div>
                        <div style="font-weight:600;font-size:14px;color:#0f172a;">Goods Management</div>
                        <div style="font-size:12px;color:#94a3b8;">Manage inventory items</div>
                    </div>
                </div>
                <a href="goods.php" class="btn btn-primary btn-sm mt-auto">
                    <i class="bi bi-arrow-right me-1"></i>Go to Goods
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div style="width:40px;height:40px;background:#f0fdf4;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-tags" style="font-size:18px;color:#10b981;"></i>
                    </div>
                    <div>
                        <div style="font-weight:600;font-size:14px;color:#0f172a;">Categories</div>
                        <div style="font-size:12px;color:#94a3b8;">Organize products</div>
                    </div>
                </div>
                <a href="categories.php" class="btn btn-sm mt-auto" style="background:#10b981;color:#fff;border:none;">
                    <i class="bi bi-arrow-right me-1"></i>Go to Categories
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div style="width:40px;height:40px;background:#fffbeb;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-bar-chart-line" style="font-size:18px;color:#f59e0b;"></i>
                    </div>
                    <div>
                        <div style="font-weight:600;font-size:14px;color:#0f172a;">Reports</div>
                        <div style="font-size:12px;color:#94a3b8;">View inventory insights</div>
                    </div>
                </div>
                <a href="report.php" class="btn btn-sm mt-auto" style="background:#f59e0b;color:#fff;border:none;">
                    <i class="bi bi-arrow-right me-1"></i>View Report
                </a>
            </div>
        </div>
    </div>
    <?php if ($user_role === 'admin'): ?>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div style="width:40px;height:40px;background:#f5f3ff;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-people" style="font-size:18px;color:#8b5cf6;"></i>
                        </div>
                        <div>
                            <div style="font-weight:600;font-size:14px;color:#0f172a;">User Management</div>
                            <div style="font-size:12px;color:#94a3b8;">Manage system users</div>
                        </div>
                    </div>
                    <a href="users.php" class="btn btn-sm mt-auto" style="background:#8b5cf6;color:#fff;border:none;">
                        <i class="bi bi-arrow-right me-1"></i>Manage Users
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>