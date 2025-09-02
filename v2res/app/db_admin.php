<?php
// app/db_admin.php
$DB_HOST = 'localhost';
$DB_NAME = 'reservations';
$DB_USER = 'reservation_admin';
$DB_PASS = 'admin_password_123';

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    die('Database connection failed (admin): ' . htmlspecialchars($e->getMessage()));
}
?>
