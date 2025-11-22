<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: views/auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Dashboard - Inventory Gudang</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="topbar">
    <div class="container">
      <div class="brand">Inventory Gudang</div>
      <nav class="nav">
        <span class="welcome">Halo, <?= htmlspecialchars($_SESSION['user']) ?></span>
        <a class="btn-ghost" href="logout.php">Logout</a>
      </nav>
    </div>
  </header>

  <main class="container mt-20">
    <h1>Dashboard Sistem Inventory Gudang</h1>
    <p class="lead">Ini adalah dashboard awal. Minggu depan akan muncul menu CRUD dan transaksi.</p>

    <section class="grid-4 gap-16 mt-20">

    <a href="controllers/BarangController.php?action=index" class="card card-link">
      <h3>Master Barang</h3>
      <p>Kelola data barang (kode, nama, kategori, stok minimum).</p>
    </a>

    <a href="controllers/KategoriController.php?action=index" class="card card-link">
      <h3>Master Kategori</h3>
      <p>Kelola data kategori barang.</p>
    </a>

    <a href="controllers/SupplierController.php?action=index" class="card card-link">
      <h3>Master Supplier</h3>
      <p>Kelola data pemasok barang.</p>
    </a>

    <a href="controllers/GudangController.php?action=index" class="card card-link">
      <h3>Master Gudang</h3>
      <p>Kelola data lokasi gudang penyimpanan.</p>
    </a>

  </section>

  </main>
</body>
</html>
