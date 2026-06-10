<?php
require_once 'config/db.php';
if ($_SESSION['role'] !== 'admin') {
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

    $stmt = $pdo->prepare("INSERT INTO goods (name, description, price, unit, stock, category_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $description, $price, $unit, $stock, $category_id]);

    $_SESSION['message'] = "Good added successfully!";
    header("Location: goods.php");
    exit();
}
include 'includes/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-header-title">Add New Good</h1>
        <div class="page-header-subtitle">Fill in the details for the new inventory item</div>
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
                <input type="text" name="name" class="form-control" placeholder="Item name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Description"></textarea>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-sm-6">
                    <label class="form-label">Price <span class="text-danger">*</span></label>
                    <input type="text" name="price" id="price" class="form-control" placeholder="Rp 0" required>
                </div>
                <div class="col-sm-6">
                    <label class="form-label">Stock <span class="text-danger">*</span></label>
                    <input type="number" min="0" name="stock" class="form-control" placeholder="0" required>
                </div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-sm-6">
                    <label class="form-label">Unit <span class="text-danger">*</span></label>
                    <select name="unit" class="form-select" required>
                        <option value="">Select Unit</option>
                        <option value="pcs">Pcs</option>
                        <option value="bottle">Bottle</option>
                        <option value="pack">Pack</option>
                        <option value="set">Set</option>
                        <option value="box">Box</option>
                    </select>
                </div>
                <div class="col-sm-6">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="d-flex gap-2 pt-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>Save Item
                </button>
                <a href="goods.php" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>