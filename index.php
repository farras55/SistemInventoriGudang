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
      <article class="card">
        <h3>Master Barang</h3>
        <p>Kelola data barang (kode, nama, kategori, stok minimum).</p>
      </article>

      <article class="card">
        <h3>Transaksi Masuk</h3>
        <p>Form penerimaan barang dari supplier (dengan nomor PO).</p>
      </article>

      <article class="card">
        <h3>Transaksi Keluar</h3>
        <p>Form pengeluaran barang (validasi stok otomatis).</p>
      </article>

      <article class="card">
        <h3>Laporan Stok</h3>
        <p>Mutasi stok, stok opname, slow-moving, ringkasan per kategori.</p>
      </article>
    </section>
  </main>
</body>
</html>
