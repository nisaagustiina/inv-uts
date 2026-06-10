<?php
require_once 'config/db.php';
if ($_SESSION['role'] !== 'admin') {
    header("Location: goods.php");
    exit();
}

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("DELETE FROM goods WHERE id = ?");
$stmt->execute([$id]);

$_SESSION['message'] = "Good deleted successfully!";
header("Location: goods.php");
exit();
?>