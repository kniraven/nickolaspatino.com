<?php
$projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);
require_once $projectRoot . '/config/employeemanager_db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM employees WHERE id = ?");
$stmt->execute([$id]);

header('Location: index.php');
exit();
?>
