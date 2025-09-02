<?php
// admin/add_table.php
session_start();
if (empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../app/db_admin.php';


$table_number = trim($_POST['table_number'] ?? '');
$capacity = (int)($_POST['capacity'] ?? 0);
$status = $_POST['status'] ?? 'available';

if ($table_number && in_array($capacity, [2,4,6]) && in_array($status, ['available','reserved','maintenance'])) {
    $stmt = $pdo->prepare("INSERT INTO tables (table_number, capacity, status) VALUES (:tn, :cap, :st)");
    try {
        $stmt->execute([':tn'=>$table_number, ':cap'=>$capacity, ':st'=>$status]);
    } catch (Throwable $e) {
        // ignore if duplicate
    }
}
header('Location: dashboard.php');
