<?php
// admin/delete_table.php
session_start();
if (empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../app/db_admin.php';


$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id > 0) {
    // Prevent deleting tables that have future reservations
    $check = $pdo->prepare("SELECT COUNT(*) AS cnt FROM reservations WHERE table_id = :id AND reservation_date >= CURDATE() AND status='confirmed'");
    $check->execute([':id' => $id]);
    $row = $check->fetch();
    if ((int)$row['cnt'] === 0) {
        $stmt = $pdo->prepare("DELETE FROM tables WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}
header('Location: dashboard.php');
