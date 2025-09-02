<?php
// public/contact.php
require_once __DIR__ . '/../app/db_public.php';
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
      <a href="about.php" >About us</a>
      <a href="contact.php" class="active">Contact Us</a>
      <a href="index.php" >Reserve Us</a>
      <a href="../admin/login.php">Staff Login</a>
    </nav>
  </header>
  <main class="container">
    <section class="card">
        <h2>Contact Us</h2>
              <div >
        <div >Phone: <strong>+123 456 789</strong></div>
        <div >Email: <strong><a href="mailto:BelgradeBistro@xyz.com">BelgradeBistro@xyz.com</a></strong></div>
        <div >Instagram: <strong><a href="">@Belgrade_Bistro</a></strong></div>
      </div>
    </section>
    </main>
  <footer class="site-footer">
    <small>© <?php echo date('Y'); ?> Belgrade Bistro</small>
  </footer>
</body>
</html>