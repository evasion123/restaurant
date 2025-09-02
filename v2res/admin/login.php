<?php
// admin/login.php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';
    if ($user === 'admin' && $pass === 'admin') {
        $_SESSION['admin'] = true;
        header('Location: dashboard.php');
        exit;
    }
    $error = "Invalid credentials";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff Login</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
  <main class="container narrow">
    <section class="card">
      <h2>Staff Login</h2>
      <?php if (!empty($error)): ?><div class="toast error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
      <form class="form" method="POST">
        <label>Username <input type="text" name="username" required></label>
        <label>Password <input type="password" name="password" required></label>
        <button class="btn" type="submit">Login</button>
      </form>
      <p class="muted"><a href="../public/index.php">&larr; Back to Reservations</a></p>
    </section>
  </main>
</body>
</html>
