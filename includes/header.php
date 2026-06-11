<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// public page yang diizinkan
$public_pages = ['login.php', 'register.php'];
$current_page = basename($_SERVER['PHP_SELF']);
if (!isset($_SESSION['user_id']) && !in_array($current_page, $public_pages)) {
    header("Location: login.php");
    exit();
}
// jika login, defined user info
$user_role = $_SESSION['role'] ?? null;
$user_name = $_SESSION['user_name'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InvSys — Inventory Management</title>
    <link href="assets/bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-active: #3b82f6;
            --sidebar-width: 240px;
            --topbar-height: 60px;
            --accent: #3b82f6;
            --accent-dark: #2563eb;
        }

        * { box-sizing: border-box; }

        body {
            background: #f1f5f9;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            z-index: 1040;
            overflow-y: auto;
            transition: transform 0.25s ease;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px 20px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }

        .sidebar-brand-icon {
            width: 34px; height: 34px;
            background: var(--accent);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: 16px;
            flex-shrink: 0;
        }

        .sidebar-brand-text {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.3px;
        }

        .sidebar-brand-text small {
            display: block;
            font-size: 10px;
            font-weight: 400;
            color: #64748b;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Close button inside sidebar — mobile only */
        .sidebar-close {
            display: none;
            position: absolute;
            top: 14px; right: 14px;
            background: rgba(255,255,255,0.08);
            border: none;
            color: #94a3b8;
            width: 30px; height: 30px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            align-items: center; justify-content: center;
            transition: background 0.15s;
        }

        .sidebar-close:hover { background: rgba(255,255,255,0.14); color: #fff; }

        .sidebar-user {
            padding: 14px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            margin-bottom: 6px;
        }

        .sidebar-user-name {
            color: #e2e8f0;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .sidebar-user-role {
            display: inline-block;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            padding: 2px 8px;
            border-radius: 20px;
            background: rgba(59,130,246,0.2);
            color: #93c5fd;
        }

        .sidebar-section-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #475569;
            padding: 12px 20px 4px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 20px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: all 0.15s ease;
        }

        .sidebar-nav a:hover { background: var(--sidebar-hover); color: #e2e8f0; }

        .sidebar-nav a.active {
            background: rgba(59,130,246,0.12);
            color: #60a5fa;
            border-left-color: var(--accent);
        }

        .sidebar-nav a i { font-size: 15px; width: 18px; text-align: center; }

        .sidebar-nav a.nav-logout { color: #f87171; margin-top: auto; }
        .sidebar-nav a.nav-logout:hover { background: rgba(239,68,68,0.1); color: #fca5a5; }

        .sidebar-spacer { flex: 1; }

        /* ── Overlay (mobile) ── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 1039;
            opacity: 0;
            transition: opacity 0.25s ease;
        }

        .sidebar-overlay.show { display: block; opacity: 1; }

        /* ── Main Layout ── */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.25s ease;
        }

        .topbar {
            height: var(--topbar-height);
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            padding: 0 20px;
            position: sticky;
            top: 0;
            z-index: 100;
            gap: 12px;
        }

        /* Hamburger */
        .topbar-toggle {
            display: none;
            background: none;
            border: none;
            color: #475569;
            font-size: 20px;
            padding: 4px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .topbar-toggle:hover { color: #0f172a; }

        .topbar-title {
            font-size: 16px;
            font-weight: 600;
            color: #0f172a;
        }

        .page-content {
            padding: 24px;
            flex: 1;
        }

        /* ── Cards ── */
        .card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            border-radius: 12px 12px 0 0 !important;
            padding: 16px 20px;
        }

        /* ── Stats Cards ── */
        .stat-card {
            border-radius: 12px;
            padding: 20px;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            right: -15px; top: -15px;
            width: 80px; height: 80px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
        }

        .stat-card-icon {
            width: 44px; height: 44px;
            border-radius: 10px;
            background: rgba(255,255,255,0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            color: #fff;
            margin-bottom: 12px;
        }

        .stat-card-value {
            font-size: 26px;
            font-weight: 700;
            color: #fff;
            line-height: 1;
            margin-bottom: 4px;
        }

        .stat-card-label {
            font-size: 12px;
            color: rgba(255,255,255,0.8);
            font-weight: 500;
        }

        /* ── Table ── */
        .table-card {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            background: #fff;
        }

        /* Make table scrollable on small screens */
        .table-card .table-responsive {
            border-radius: 12px 12px 0 0;
        }

        .table-card .table {
            margin: 0;
            font-size: 13.5px;
        }

        .table-card .table thead th {
            background: #f8fafc;
            color: #475569;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 16px;
            white-space: nowrap;
        }

        .table-card .table tbody tr:last-child td { border-bottom: 0; }

        .table-card .table tbody td {
            padding: 12px 16px;
            vertical-align: middle;
            color: #334155;
            border-color: #f1f5f9;
        }

        .table-card .table tbody tr:hover { background: #f8fafc; }

        /* ── Badges ── */
        .role-badge {
            font-size: 10px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .role-badge.admin { background: #dbeafe; color: #1d4ed8; }
        .role-badge.user  { background: #dcfce7; color: #16a34a; }

        /* ── Buttons ── */
        .btn { font-size: 13px; font-weight: 500; border-radius: 8px; }

        .btn-primary { background: var(--accent); border-color: var(--accent); }
        .btn-primary:hover { background: var(--accent-dark); border-color: var(--accent-dark); }

        .btn-sm { font-size: 12px; padding: 4px 10px; border-radius: 6px; }
        .btn-action-group { display: flex; gap: 4px; flex-wrap: nowrap; }

        /* ── Forms ── */
        .form-label { font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 5px; }

        .form-control, .form-select {
            border-radius: 8px;
            border-color: #d1d5db;
            font-size: 13.5px;
            padding: 8px 12px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
        }

        /* ── Page Header ── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 12px;
        }

        .page-header-title {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }

        .page-header-subtitle { font-size: 13px; color: #94a3b8; margin-top: 2px; }

        /* ── Alert ── */
        .alert { border-radius: 10px; font-size: 13.5px; border: none; }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-danger  { background: #fee2e2; color: #991b1b; }

        /* ── Form Card ── */
        .form-card { max-width: 580px; }
        @media (max-width: 767px) {

            .sidebar {
                transform: translateX(-100%);
                width: 260px;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-close { display: flex; }
            .main-wrapper { margin-left: 0; }
            .topbar-toggle { display: block; }
            .page-content { padding: 16px; }
            .page-header { flex-wrap: wrap; }
            .page-header > .btn,
            .page-header > a { font-size: 12px; padding: 6px 12px; }
            .stat-card-value { font-size: 22px; }s
            .table-card {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            .page-link { padding: 5px 9px; font-size: 12px; }
            .form-card { max-width: 100%; }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            :root { --sidebar-width: 200px; }

            .sidebar-brand-text { font-size: 13px; }
            .sidebar-nav a { font-size: 13px; padding: 8px 16px; }
            .sidebar-section-label { padding: 10px 16px 4px; }

            .page-content { padding: 20px; }
        }
    </style>
</head>
<body>
<?php
$pages = [
    'dashboard.php'     => 'Dashboard',
    'goods.php'         => 'Goods',
    'add_good.php'      => 'Add Good',
    'edit_good.php'     => 'Edit Good',
    'categories.php'    => 'Categories',
    'add_category.php'  => 'Add Category',
    'edit_category.php' => 'Edit Category',
    'users.php'         => 'Users',
    'add_user.php'      => 'Add User',
    'edit_user.php'     => 'Edit User',
    'report.php'        => 'Report',
];
$page_title = $pages[$current_page] ?? 'Inventory';
?>

<!-- Overlay (mobile backdrop) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <button class="sidebar-close" id="sidebarClose" aria-label="Close menu">
        <i class="bi bi-x"></i>
    </button>

    <div class="sidebar-brand">
        <div class="sidebar-brand-icon"><i class="bi bi-box-seam"></i></div>
        <div class="sidebar-brand-text">InvSys<small>Inventory</small></div>
    </div>

    <?php if ($user_name): ?>
    <div class="sidebar-user">
        <div class="sidebar-user-name"><?php echo htmlspecialchars($user_name); ?></div>
        <span class="sidebar-user-role"><?php echo ucfirst($user_role); ?></span>
    </div>
    <?php endif; ?>

    <div class="sidebar-section-label">Menu</div>
    <nav class="sidebar-nav">
        <a href="dashboard.php" class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>
        <a href="goods.php" class="<?php echo in_array($current_page, ['goods.php','add_good.php','edit_good.php']) ? 'active' : ''; ?>">
            <i class="bi bi-box"></i> Goods
        </a>
        <a href="categories.php" class="<?php echo in_array($current_page, ['categories.php','add_category.php','edit_category.php']) ? 'active' : ''; ?>">
            <i class="bi bi-tags"></i> Categories
        </a>
        <a href="report.php" class="<?php echo $current_page == 'report.php' ? 'active' : ''; ?>">
            <i class="bi bi-bar-chart-line"></i> Report
        </a>
        <?php if ($user_role === 'admin'): ?>
        <div class="sidebar-section-label" style="margin-top:8px;">Admin</div>
        <a href="users.php" class="<?php echo in_array($current_page, ['users.php','add_user.php','edit_user.php']) ? 'active' : ''; ?>">
            <i class="bi bi-people"></i> Users
        </a>
        <?php endif; ?>

        <div class="sidebar-spacer"></div>
        <a href="logout.php" class="nav-logout" style="margin-top:16px;">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </nav>
</aside>

<!-- Main Wrapper -->
<div class="main-wrapper">
    <!-- Topbar -->
    <div class="topbar">
        <button class="topbar-toggle" id="sidebarToggle" aria-label="Toggle menu">
            <i class="bi bi-list"></i>
        </button>
        <span class="topbar-title"><?php echo $page_title; ?></span>
    </div>

    <!-- Page Content -->
    <div class="page-content">

        <!-- Flash Messages -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle me-2"></i><?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i><?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
