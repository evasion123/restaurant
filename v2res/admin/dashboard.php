<?php
// admin/dashboard.php
session_start();
if (empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../app/db_admin.php';


// Fetch reservations
$resStmt = $pdo->query("
    SELECT r.id, r.customer_name, r.customer_email, r.customer_phone,
           r.reservation_date, r.reservation_time, r.party_size, r.status,
           t.table_number, t.capacity
      FROM reservations r
      LEFT JOIN tables t ON t.id = r.table_id
     ORDER BY r.reservation_date ASC, r.reservation_time ASC
");
$reservations = $resStmt->fetchAll();

// Fetch tables
$tabStmt = $pdo->query("SELECT id, table_number, capacity, status FROM tables ORDER BY table_number ASC");
$tables = $tabStmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<header class="site-header">
  <h1>Staff Dashboard</h1>
  <nav>
    <a href="dashboard.php" class="active">Overview</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>
<main class="container">
  <section class="card">
    <h2>Reservations</h2>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Table</th>
            <th>Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Party</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($reservations as $r): ?>
          <tr>
            <td><?php echo (int)$r['id']; ?></td>
            <td><?php echo htmlspecialchars($r['table_number'] ?? 'N/A'); ?> (<?php echo (int)$r['capacity']; ?>)</td>
            <td>
              <?php echo htmlspecialchars($r['customer_name']); ?><br>
              <small class="muted"><?php echo htmlspecialchars($r['customer_email']); ?><?php if ($r['customer_phone']) echo ' • ' . htmlspecialchars($r['customer_phone']); ?></small>
            </td>
            <td><?php echo htmlspecialchars($r['reservation_date']); ?></td>
            <td><?php echo htmlspecialchars(substr($r['reservation_time'],0,5)); ?></td>
            <td><?php echo (int)$r['party_size']; ?></td>
            <td><?php echo htmlspecialchars($r['status']); ?></td>
            <td>
              <form action="delete_reservation.php" method="POST" onsubmit="return confirm('Delete reservation #<?php echo (int)$r['id']; ?>?')">
                <input type="hidden" name="id" value="<?php echo (int)$r['id']; ?>">
                <button class="btn danger" type="submit">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>

  <section class="card">
    <h2>Tables</h2>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Number</th>
            <th>Capacity</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($tables as $t): ?>
          <tr>
            <td><?php echo (int)$t['id']; ?></td>
            <td><?php echo htmlspecialchars($t['table_number']); ?></td>
            <td><?php echo (int)$t['capacity']; ?></td>
            <td><?php echo htmlspecialchars($t['status']); ?></td>
            <td>
              <form action="delete_table.php" method="POST" onsubmit="return confirm('Delete table <?php echo htmlspecialchars($t['table_number']); ?>? This cannot be undone.');">
                <input type="hidden" name="id" value="<?php echo (int)$t['id']; ?>">
                <button class="btn danger" type="submit">Remove</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <h3>Add Table</h3>
    <form class="form" method="POST" action="add_table.php">
      <div class="grid">
        <label>Table Number
          <input type="text" name="table_number" required maxlength="10" placeholder="e.g., T13">
        </label>
        <label>Capacity
          <select name="capacity" required>
            <option value="2">2</option>
            <option value="4">4</option>
            <option value="6">6</option>
          </select>
        </label>
        <label>Status
          <select name="status" required>
            <option value="available">available</option>
            <option value="reserved">reserved</option>
            <option value="maintenance">maintenance</option>
          </select>
        </label>
      </div>
      <button class="btn" type="submit">Add Table</button>
    </form>
  </section>
</main>
</body>
</html>
