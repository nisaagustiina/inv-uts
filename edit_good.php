<?php
require_once 'config/db.php';
if ($_SESSION['role'] !== 'admin') {
    header("Location: goods.php");
    exit();
}

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM goods WHERE id = ?");
$stmt->execute([$id]);
$good = $stmt->fetch();
if (!$good) {
    header("Location: goods.php");
    exit();
}

$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = $_POST['name'];
    $description = $_POST['description'];
    $price       = preg_replace('/[^0-9]/', '', $_POST['price']);
    $unit        = $_POST['unit'];
    $stock       = $_POST['stock'];
    $category_id = $_POST['category_id'];
    $stmt = $pdo->prepare("UPDATE goods SET name=?, description=?, price=?, unit=?, stock=?, category_id=? WHERE id=?");
    $stmt->execute([$name, $description, $price, $unit, $stock, $category_id, $id]);
    $_SESSION['message'] = "Good updated successfully!";
    header("Location: goods.php");
    exit();
}
include 'includes/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-header-title">Edit Good</h1>
        <div class="page-header-subtitle">Update details for "<?php echo htmlspecialchars($good['name']); ?>"</div>
    </div>
    <a href="goods.php" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Back to Goods
    </a>
</div>

<div class="card form-card">
    <div class="card-body p-4">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Item Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($good['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($good['description']); ?></textarea>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-sm-6">
                    <label class="form-label">Price <span class="text-danger">*</span></label>
                    <input type="text" id="price" name="price" class="form-control"
                        value="<?php echo 'Rp ' . number_format($good['price'], 0, ',', '.'); ?>"
                        required>
                </div>
                <div class="col-sm-6">
                    <label class="form-label">Stock <span class="text-danger">*</span></label>
                    <input type="number" min="0" name="stock" class="form-control" placeholder="0" value="<?php echo $good['stock']; ?>" required>
                </div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-sm-6">
                    <label class="form-label">Unit <span class="text-danger">*</span></label>
                    <select name="unit" class="form-select" required>
                        <option value="">Select Unit</option>
                        <option value="pcs" <?php echo $good['unit'] == 'pcs' ? 'selected' : ''; ?>>Pcs</option>
                        <option value="bottle" <?php echo $good['unit'] == 'bottle' ? 'selected' : ''; ?>>Bottle</option>
                        <option value="pack" <?php echo $good['unit'] == 'pack' ? 'selected' : ''; ?>>Pack</option>
                        <option value="set" <?php echo $good['unit'] == 'set' ? 'selected' : ''; ?>>Set</option>
                        <option value="box" <?php echo $good['unit'] == 'box' ? 'selected' : ''; ?>>Box</option>
                    </select>
                </div>
                <div class="col-sm-6">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select" required>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" <?php echo $cat['id'] == $good['category_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="d-flex gap-2 pt-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>Update Item
                </button>
                <a href="goods.php" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>