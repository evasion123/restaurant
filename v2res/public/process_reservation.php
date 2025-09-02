<?php
// public/process_reservation.php
require_once __DIR__ . '/../app/db_public.php';

function redirect_with($params) {
    $q = http_build_query($params);
    header("Location: index.php?$q");
    exit;
}

$required = ['customer_name','customer_email','party_size','reservation_date','reservation_time'];
foreach ($required as $key) {
    if (empty($_POST[$key])) {
        redirect_with(['error' => 'Please fill in all required fields.']);
    }
}

$customer_name = trim($_POST['customer_name']);
$customer_email = trim($_POST['customer_email']);
$customer_phone = isset($_POST['customer_phone']) ? trim($_POST['customer_phone']) : null;
$party_size = (int)$_POST['party_size'];
$res_date = $_POST['reservation_date'];
$res_time = $_POST['reservation_time'];
$special = isset($_POST['special_requests']) ? trim($_POST['special_requests']) : null;

if (!in_array($party_size, [2,4,6])) {
    redirect_with(['error' => 'Party size must be 2, 4, or 6.']);
}

try {
    // Find an available table
    $sql = "SELECT t.id
            FROM tables t
            LEFT JOIN reservations r
              ON r.table_id = t.id
             AND r.reservation_date = :res_date
             AND r.reservation_time = :res_time
             AND r.status = 'confirmed'
            WHERE t.capacity = :cap
              AND t.status = 'available'
              AND r.id IS NULL
            ORDER BY t.id ASC
            LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':res_date' => $res_date,
        ':res_time' => $res_time,
        ':cap' => $party_size,
    ]);
    $table = $stmt->fetch();

    if (!$table) {
        redirect_with(['error' => 'No tables available for that time. Please try a different time or party size.']);
    }

    // Create reservation
    $ins = $pdo->prepare("INSERT INTO reservations 
        (table_id, customer_name, customer_email, customer_phone, reservation_date, reservation_time, party_size, special_requests, status)
        VALUES (:tid, :name, :email, :phone, :rdate, :rtime, :psize, :special, 'confirmed')");
    $ins->execute([
        ':tid' => $table['id'],
        ':name' => $customer_name,
        ':email' => $customer_email,
        ':phone' => $customer_phone,
        ':rdate' => $res_date,
        ':rtime' => $res_time,
        ':psize' => $party_size,
        ':special' => $special,
    ]);

    redirect_with(['success' => 1]);
} catch (Throwable $e) {
    redirect_with(['error' => 'Server error: ' . htmlspecialchars($e->getMessage())]);
}
