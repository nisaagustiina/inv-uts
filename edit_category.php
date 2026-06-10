<?php
require_once 'config/db.php';
if ($_SESSION['role'] !== 'admin') {
    header("Location: categories.php");
    exit();
}

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$id]);
$cat = $stmt->fetch();
if (!$cat) {
    header("Location: categories.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
    $stmt->execute([$name, $id]);
    $_SESSION['message'] = "Category updated successfully!";
    header("Location: categories.php");
    exit();
}
include 'includes/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-header-title">Edit Category</h1>
        <div class="page-header-subtitle">Rename "<?php echo htmlspecialchars($cat['name']); ?>"</div>
    </div>
    <a href="categories.php" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Back to Categories
    </a>
</div>

<div class="card form-card">
    <div class="card-body p-4">
        <form method="POST">
            <div class="mb-4">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($cat['name']); ?>" required>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>Update Category
                </button>
                <a href="categories.php" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>