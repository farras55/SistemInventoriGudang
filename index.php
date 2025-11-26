<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: views/auth/login.php");
    exit;
}

$title = "Dashboard";
include __DIR__ . '/views/layout/header.php';
?>

<div class="dashboard">
    <h2>Dashboard Sistem Inventory Gudang</h2>
    <p class="muted">Halaman ini masih kosong. Grafik & statistik akan muncul setelah semua modul selesai.</p>

    <div class="empty-box">
        <p><strong>ℹ️ Belum ada konten dashboard.</strong></p>
        <p>Nantinya grafik transaksi 30 hari terakhir, barang terlaris, & ringkasan mutasi akan muncul di sini.</p>
    </div>
</div>

<?php include __DIR__ . '/views/layout/footer.php'; ?>
