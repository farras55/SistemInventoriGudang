<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Login - Sistem Inventory Gudang</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="../../style.css">
</head>
<body>
  <main class="center-page">
    <div class="card form-box">
      <h2 class="card-title">Login Admin</h2>

      <?php if (isset($_GET['error'])): ?>
        <div class="alert"><?= htmlspecialchars($_GET['error']) ?></div>
      <?php endif; ?>

      <form method="POST" action="../../controllers/AuthController.php" class="form">
        <label class="label">Username
          <input type="text" name="username" required class="input">
        </label>

        <label class="label">Password
          <input type="password" name="password" required class="input">
        </label>

        <button class="btn" type="submit">Login</button>
      </form>

      <p class="muted">Akun default: <strong>admin / admin123</strong></p>
    </div>
  </main>

  <script>
    // small progressive enhancement: focus on first input
    document.addEventListener('DOMContentLoaded', function(){
      var el = document.querySelector('input[name="username"]');
      if(el) el.focus();
    });
  </script>
</body>
</html>
