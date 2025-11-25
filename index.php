<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: views/auth/login.php");
    exit;
}

$title = "Dashboard";
include __DIR__ . '/views/layout/header.php';
?>

<div class="content-inner">
    <h2 style="margin:0 0 10px 0;">Dashboard Sistem Inventory Gudang</h2>
    <p style="color:#6b7280; margin-bottom:20px;">
        Selamat datang di Sistem Inventory Gudang.  
        Dashboard ini masih kosong dan akan berisi grafik & ringkasan setelah semua modul selesai.
    </p>

    <div class="card" style="padding:20px;">
        <p style="margin:0; color:#555;">
            🛈 Belum ada konten dashboard.<br>
            Setelah modul transaksi selesai, grafik mutasi 30 hari terakhir & statistik barang akan muncul di sini.
        </p>
    </div>
</div>

<?php include __DIR__ . '/views/layout/footer.php'; ?>
