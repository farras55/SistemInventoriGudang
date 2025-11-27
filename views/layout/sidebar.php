<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<aside class="sidebar">
    <div class="sidebar-header">
        <h2>Inventory</h2>
    </div>

    <nav class="sidebar-menu">

        <a href="/../index.php" class="menu-item">📊 Dashboard</a>

        <p class="menu-label">Master Data</p>
        <a href="/../controllers/BarangController.php?action=index" class="menu-item">📦 Barang</a>
        <a href="/../controllers/KategoriController.php?action=index" class="menu-item">🗂 Kategori</a>
        <a href="/../controllers/SupplierController.php?action=index" class="menu-item">🏭 Supplier</a>
        <a href="/../controllers/GudangController.php?action=index" class="menu-item">🏬 Gudang</a>

        <p class="menu-label">Transaksi</p>
        <a href="/../controllers/TransaksiMasukController.php?action=index" class="menu-item">⬆ Barang Masuk</a>
        <a href="/../controllers/TransaksiKeluarController.php?action=index" class="menu-item">⬇ Barang Keluar</a>

        <p class="menu-label">Laporan</p>
        <a href="/../controllers/LaporanController.php?action=stokOpname" class="menu-item">📋 Stok Opname</a>
        <a href="/../controllers/LaporanController.php?action=slowMoving" class="menu-item">🐢 Barang Slow Moving</a>
        <a href="/../controllers/LaporanController.php?action=mutasi" class="menu-item">📘 Laporan Mutasi</a>
        <a href="/../controllers/LaporanController.php?action=stokRingkasan" class="menu-item">📊 Ringkasan Stok</a>

    </nav>

    <div class="sidebar-footer">
        <?php
            $displayName = '';
            if (is_array($_SESSION['user'])) {
                $displayName = $_SESSION['user']['nama_lengkap'] ?? $_SESSION['user']['username'] ?? '';
            } else {
                $displayName = (string) ($_SESSION['user'] ?? '');
            }
        ?>
        <span>👤 <?= htmlspecialchars($displayName) ?></span>
        <a href="/../logout.php" class="logout-btn">Logout</a>
    </div>
</aside>
