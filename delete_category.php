<?php
require_once 'config/db.php';
if ($_SESSION['role'] !== 'admin') {
    header("Location: categories.php");
    exit();
}

$id = $_GET['id'] ?? 0;
// Check if category has goods
$stmt = $pdo->prepare("SELECT COUNT(*) FROM goods WHERE category_id = ?");
$stmt->execute([$id]);
$count = $stmt->fetchColumn();

if ($count > 0) {
    $_SESSION['message'] = "Cannot delete category: There are $count goods associated with it.";
} else {
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['message'] = "Category deleted successfully!";
}
header("Location: categories.php");
exit();
?>