<?php
// public/index.php
require_once __DIR__ . '/../app/db_public.php';

// Fetch availability by capacity (2,4,6)
// Counts only tables that are not reserved for upcoming dates
$availability = [2=>0,4=>0,6=>0];
$sql = "SELECT t.capacity,
               COUNT(DISTINCT t.id) - COUNT(DISTINCT r.table_id) AS available
        FROM tables t
        LEFT JOIN reservations r
          ON r.table_id = t.id
         AND r.status = 'confirmed'
         AND r.reservation_date >= CURDATE()
        WHERE t.status = 'available'
        GROUP BY t.capacity";
$stmt = $pdo->query($sql);
while ($row = $stmt->fetch()) {
    $cap = (int)$row['capacity'];
    if (in_array($cap, [2,4,6])) {
        $availability[$cap] = max(0, (int)$row['available']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurant Reservations</title>
  <link rel="stylesheet" href="../assets/style.css">
  <script defer src="../assets/script.js"></script>
</head>
<body>
  <header class="site-header">
    <h1>🥐 Belgrade Bistro</h1>
    <nav>
      <a href="about.php" >About Us</a>
      <a href="contact.php" >Contact Us</a>
      <a href="index.php" class="active">Reserve</a>
      <a href="../admin/login.php">Staff Login</a>
    </nav>
  </header>

  <main class="container">
    <section class="card">
      <h2>Reserve a Table</h2>
      <p>Available tables right now:</p>
      <div class="availability">
        <div class="pill">2 seats: <strong><?php echo $availability[2]; ?></strong></div>
        <div class="pill">4 seats: <strong><?php echo $availability[4]; ?></strong></div>
        <div class="pill">6 seats: <strong><?php echo $availability[6]; ?></strong></div>
      </div>

      <form class="form" action="process_reservation.php" method="POST" novalidate>
        <div class="grid">
          <label>
            Full Name
            <input type="text" name="customer_name" required maxlength="100" placeholder="e.g., Ana Petrović">
          </label>
          <label>
            Email
            <input type="email" name="customer_email" required maxlength="100" placeholder="ana@example.com">
          </label>
          <label>
            Phone
            <input type="tel" name="customer_phone" maxlength="20" placeholder="+381 64 123 4567">
          </label>
        </div>
        <div class="grid">
          <label>
            Party Size
            <select name="party_size" required>
              <option value="">Select...</option>
              <option value="2">2 people</option>
              <option value="4">4 people</option>
              <option value="6">6 people</option>
            </select>
          </label>
          <label>
            Date
            <input type="date" name="reservation_date" required>
          </label>
          <label>
            Time
            <input type="time" name="reservation_time" required>
          </label>
        </div>
        <label>
          Orders and Special Requests (optional)
          <textarea name="special_requests" rows="3" maxlength="500" placeholder="Your order, allergies, seating preference,"></textarea>
        </label>
        <button type="submit" class="btn">Reserve</button>
      </form>
    </section>

    <?php if (isset($_GET['success'])): ?>
      <div class="toast success">✅ Reservation confirmed! You can call +123 456 789 to order your meal in advance, it will scheduled in time for your reservation!</div>
    <?php elseif (isset($_GET['error'])): ?>
      <div class="toast error">❌ <?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>
  </main>

  <footer class="site-footer">
    <small>© <?php echo date('Y'); ?> Belgrade Bistro</small>
  </footer>
</body>
</html>
