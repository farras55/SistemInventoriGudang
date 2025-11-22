<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? "Sistem Inventory Gudang" ?></title>
    <link rel="stylesheet" href="/../style.css">
</head>

<body>
    <header class="header">
        <div class="header-left">
            <h2 class="logo">Inventory Gudang</h2>
        </div>

        <nav class="nav">
            <a href="/../index.php">Dashboard</a>
            <a href="/../controllers/KategoriController.php?action=index">Kategori</a>
            <a href="/../controllers/SupplierController.php?action=index">Supplier</a>
            <a href="/../controllers/GudangController.php?action=index">Gudang</a>
            <a href="/../controllers/BarangController.php?action=index">Barang</a>
            <a href="/../controllers/TransaksiController.php?action=masuk">Transaksi Masuk</a>
            <a href="/../controllers/TransaksiController.php?action=keluar">Transaksi Keluar</a>
        </nav>

        <div class="header-right">
            <?php if (isset($_SESSION['user'])): ?>
                <span class="user-text">Halo, <?= htmlspecialchars($_SESSION['user']); ?></span>
                <a href="/../logout.php" class="btn-logout">Logout</a>
            <?php else: ?>
                <a href="/../views/Auth/login.php" class="btn-login">Login</a>
            <?php endif; ?>
        </div>
    </header>

    <main class="main-content">
