<?php
require_once 'config/db.php';
if ($_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();
if (!$user) {
    $_SESSION['error'] = "User not found!";
    header("Location: users.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']);
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $role     = $_POST['role'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?");
    $stmt->execute([$username, $email, $id]);

    if ($stmt->fetch()) {
        $_SESSION['error'] = "Username or Email already used by another user!";
        header("Location: edit_user.php?id=$id");
        exit();
    }

    if (!empty($password)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET name=?, username=?, email=?, password=?, role=? WHERE id=?");
        $stmt->execute([$name, $username, $email, $hashed, $role, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE users SET name=?, username=?, email=?, role=? WHERE id=?");
        $stmt->execute([$name, $username, $email, $role, $id]);
    }

    $_SESSION['message'] = "User updated successfully!";
    header("Location: users.php");
    exit();
}
include 'includes/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-header-title">Edit User</h1>
        <div class="page-header-subtitle">Update account details for <?php echo htmlspecialchars($user['name']); ?></div>
    </div>
    <a href="users.php" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Back to Users
    </a>
</div>

<div class="card form-card">
    <div class="card-body p-4">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Username <span class="text-danger">*</span></label>
                <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">New Password <small class="text-muted fw-normal">(leave blank to keep current)</small></label>
                <input type="password" name="password" class="form-control" placeholder="••••••••">
            </div>
            <div class="mb-4">
                <label class="form-label">Status</label>
                <select name="role" class="form-select">
                    <option value="user" <?php echo $user['role'] == 'user' ? 'selected' : ''; ?>>User</option>
                    <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>Update User
                </button>
                <a href="users.php" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>