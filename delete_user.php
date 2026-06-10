<?php
require_once 'config/db.php';
if ($_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

$id = $_GET['id'] ?? 0;
if ($id == $_SESSION['user_id']) {
    $_SESSION['error'] = "You cannot delete your own account!";
    header("Location: users.php");
    exit();
}

$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$id]);

$_SESSION['message'] = "User deleted successfully!";
header("Location: users.php");
exit();
