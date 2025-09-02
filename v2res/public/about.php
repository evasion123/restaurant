<?php
// public/about.php
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
      <a href="about.php" class="active">About Us</a>
      <a href="contact.php" >Contact Us</a>
      <a href="index.php" >Reserve</a>
      <a href="../admin/login.php">Staff Login</a>
    </nav>
  </header>
    <main class="container">
    <section class="card">
        <h2>About Us</h2>
              <div >
        <div ><strong>Belgrade Bistro</strong> brings the essence of a Parisian bistro to the heart of Belgrade. Our chef, trained in Lyon, masterfully blends classic French technique with the finest local ingredients. We invite you to an intimate culinary escape where every detail is curated for an authentic and memorable experience.</div>
      </div>
    </section>
    </main>
  <footer class="site-footer">
    <small>© <?php echo date('Y'); ?> Belgrade Bistro</small>
  </footer>
</body>
</html>